<?php

namespace App\Console\Commands;

use App\Services\ImapKlient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\SMTP;

// CRON: sprawdza nieprzeczytane wiadomosci na harnas@ i przekierowuje je wg aliasu,
// z ktorego trafily na skrzynke (reguly w tabeli harnas_przekierowania, panel /admin/przekierowania).
// Kazda sprawdzona wiadomosc jest oznaczana jako przeczytana - takze gdy nie pasuje zadna regula.
class HarnasPrzekierowania extends Command
{
    protected $signature = 'harnas:przekierowania {--dry-run : tylko pokaz co by sie stalo, bez wysylki i oznaczania}';

    protected $description = 'Przekierowuje nowe wiadomosci ze skrzynki harnas@ wg aliasu';

    // naglowek dopisywany do przekierowanych wiadomosci - chroni przed petla
    const ZNACZNIK = 'X-OSP-Przekierowanie';

    // po tylu nieudanych wysylkach wiadomosc zostaje oznaczona jako przeczytana
    const MAKS_PROB = 3;

    private array $c;

    public function handle(): int
    {
        $this->c = config('services.harnas');
        if (empty($this->c['mail']) || empty($this->c['host']) || empty($this->c['haslo'])) {
            $this->error('Brak konfiguracji HARNAS_* w .env');

            return self::FAILURE;
        }
        // CRON co minute - nie dopuszczamy do dwoch przebiegow naraz (podwojna wysylka);
        // blokada zwalnia sie sama po zakonczeniu procesu
        $blokada = fopen(storage_path('framework/harnas-przekierowania.lock'), 'c');
        if (!flock($blokada, LOCK_EX | LOCK_NB)) {
            $this->line('Poprzednie uruchomienie jeszcze trwa');

            return self::SUCCESS;
        }

        $domena = strtolower(substr(strrchr($this->c['mail'], '@'), 1));
        $suchyBieg = $this->option('dry-run');

        $reguly = DB::table('harnas_przekierowania')->where('aktywne', 1)->get()
            // bardziej szczegolowe (dluzsze) wzorce maja pierwszenstwo
            ->sortByDesc(fn ($r) => strlen(rtrim($r->alias, '*')))
            ->values();

        $imap = new ImapKlient($this->c['host'], $this->c['imap_port'], $this->c['mail'], $this->c['haslo']);
        $uidy = $imap->nieprzeczytane();
        $this->info('Nowych wiadomosci: '.count($uidy));

        foreach ($uidy as $uid) {
            $surowa = $imap->pobierz($uid);
            $naglowki = $this->naglowki($surowa);
            $messageId = trim($naglowki['message-id'][0] ?? '') ?: 'uid:'.$uid;
            $log = [
                'message_id' => mb_substr($messageId, 0, 500),
                'nadawca' => mb_substr($this->dekoduj($naglowki['from'][0] ?? ''), 0, 255),
                'temat' => mb_substr($this->dekoduj($naglowki['subject'][0] ?? ''), 0, 500),
            ];

            [$alias, $regula] = isset($naglowki[strtolower(self::ZNACZNIK)])
                ? [null, null]
                : $this->dopasuj($this->aliasy($naglowki, $domena), $reguly);

            $this->line('UID '.$uid.' | '.$log['temat'].' | alias: '.($alias ?? '-').' -> '.($regula->email ?? 'brak reguly'));
            if ($suchyBieg) {
                continue;
            }

            if (!$regula) {
                $imap->oznaczPrzeczytana($uid);
                $this->zapisz($log + ['alias' => $alias, 'status' => isset($naglowki[strtolower(self::ZNACZNIK)]) ? 'pominieto' : 'brak_reguly']);
                continue;
            }

            $log += ['alias' => $alias, 'email' => mb_substr($regula->email, 0, 500)];
            try {
                $this->przekieruj($surowa, $this->adresy($regula->email), $alias);
                $imap->oznaczPrzeczytana($uid);
                $this->zapisz($log + ['status' => 'przekierowano']);
            } catch (\Exception $e) {
                $this->error('UID '.$uid.': '.$e->getMessage());
                $proby = DB::table('harnas_przekierowania_log')
                    ->where('message_id', $log['message_id'])->where('status', 'blad')->count() + 1;
                if ($proby >= self::MAKS_PROB) {
                    $imap->oznaczPrzeczytana($uid);
                }
                $this->zapisz($log + ['status' => 'blad', 'blad' => mb_substr('proba '.$proby.': '.$e->getMessage(), 0, 500)]);
            }
        }

        $imap->rozlacz();

        return self::SUCCESS;
    }

    // naglowki wiadomosci: nazwa (male litery) => lista wartosci w kolejnosci wystapienia
    private function naglowki(string $surowa): array
    {
        $koniec = strpos($surowa, "\r\n\r\n");
        $blok = $koniec === false ? $surowa : substr($surowa, 0, $koniec);
        $naglowki = [];
        foreach (preg_split('/\r?\n(?![ \t])/', $blok) as $wiersz) {
            if (str_contains($wiersz, ':')) {
                [$nazwa, $wartosc] = explode(':', $wiersz, 2);
                $naglowki[strtolower(trim($nazwa))][] = trim(preg_replace('/\r?\n[ \t]+/', ' ', $wartosc));
            }
        }

        return $naglowki;
    }

    // adresy z domeny jednostki, przez ktore wiadomosc mogla trafic na harnas@ (najpewniejsze pierwsze);
    // sama skrzynka harnas@ liczy sie tylko, gdy poczta przyszla wprost na nia (Delivered-To jest zawsze harnas@)
    private function aliasy(array $naglowki, string $domena): array
    {
        $zrodla = array_merge(
            $naglowki['envelope-to'] ?? [],
            $naglowki['x-original-to'] ?? [],
            $naglowki['x-envelope-to'] ?? [],
            preg_grep('/\bfor\s+<?[^\s;>]+@/i', $naglowki['received'] ?? []) ?: [],
            $naglowki['to'] ?? [],
            $naglowki['cc'] ?? [],
            $naglowki['delivered-to'] ?? [],
        );
        preg_match_all('/[a-z0-9._%+\-]+@'.preg_quote($domena, '/').'\b/i', implode(' ', $zrodla), $m);
        $adresy = array_values(array_unique(array_map('strtolower', $m[0])));
        $skrzynka = strtolower($this->c['mail']);

        $aliasy = array_values(array_diff($adresy, [$skrzynka]));

        return $aliasy ?: [$skrzynka];
    }

    // pierwszy alias, dla ktorego istnieje regula; zwraca [alias, regula|null]
    private function dopasuj(array $aliasy, $reguly): array
    {
        foreach ($aliasy as $adres) {
            $lokalna = strstr($adres, '@', true);
            foreach ($reguly as $r) {
                $wzorzec = strtolower(trim($r->alias));
                $pasuje = str_contains($wzorzec, '@')
                    ? fnmatch($wzorzec, $adres)
                    : (str_contains($wzorzec, '*') || str_contains($wzorzec, '?')
                        ? fnmatch($wzorzec, $lokalna)
                        : str_starts_with($lokalna, $wzorzec));
                if ($pasuje) {
                    return [$adres, $r];
                }
            }
        }

        return [$aliasy[0] ?? null, null];
    }

    // "a@x.pl, b@y.pl" -> lista poprawnych adresow, bez samej skrzynki harnas@ (petla)
    private function adresy(string $lista): array
    {
        $adresy = array_filter(
            array_map('trim', preg_split('/[,;\s]+/', $lista)),
            fn ($a) => filter_var($a, FILTER_VALIDATE_EMAIL) && strcasecmp($a, $this->c['mail']) !== 0
        );
        if (!$adresy) {
            throw new \Exception('Brak poprawnego adresu docelowego w regule');
        }

        return array_values($adresy);
    }

    // przekierowanie (redirect) - oryginalna wiadomosc wysylana bez zmian na nowy adres,
    // z dopisanymi naglowkami Resent-*; podpis DKIM nadawcy pozostaje wazny
    private function przekieruj(string $surowa, array $do, ?string $alias): void
    {
        $dodatkowe = 'Resent-From: '.$this->c['mail']."\r\n"
            .'Resent-To: '.implode(', ', $do)."\r\n"
            .'Resent-Date: '.date(DATE_RFC2822)."\r\n"
            .self::ZNACZNIK.': '.($alias ?? $this->c['mail'])."\r\n";
        $tresc = $dodatkowe.preg_replace('/\r?\n/', "\r\n", $surowa);

        $smtp = new SMTP();
        $smtp->Timeout = 30;
        $blad = fn ($krok) => new \Exception('SMTP '.$krok.': '.($smtp->getError()['error'] ?? '').' '.($smtp->getError()['detail'] ?? ''));

        if (!$smtp->connect(($this->c['smtp_port'] == 465 ? 'ssl://' : '').$this->c['host'], $this->c['smtp_port'])) {
            throw $blad('connect');
        }
        try {
            $smtp->hello(gethostname() ?: 'localhost');
            if ($this->c['smtp_port'] != 465) {
                if (!$smtp->startTLS()) {
                    throw $blad('starttls');
                }
                $smtp->hello(gethostname() ?: 'localhost');
            }
            if (!$smtp->authenticate($this->c['mail'], $this->c['haslo'])) {
                throw $blad('auth');
            }
            if (!$smtp->mail($this->c['mail'])) {
                throw $blad('mail from');
            }
            foreach ($do as $adres) {
                if (!$smtp->recipient($adres)) {
                    throw $blad('rcpt '.$adres);
                }
            }
            if (!$smtp->data($tresc)) {
                throw $blad('data');
            }
        } finally {
            $smtp->quit();
            $smtp->close();
        }
    }

    private function dekoduj(string $tekst): string
    {
        return trim(str_contains($tekst, '=?') ? mb_decode_mimeheader($tekst) : $tekst);
    }

    private function zapisz(array $wpis): void
    {
        DB::table('harnas_przekierowania_log')->insert($wpis + ['created_at' => now()]);
    }
}
