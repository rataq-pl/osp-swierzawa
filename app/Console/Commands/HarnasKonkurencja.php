<?php

namespace App\Console\Commands;

use App\Http\Controllers\Harnas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

// CRON: zapisuje liczbe glosow pierwszych 20 jednostek rankingu osp-harnas.pl (oraz OSP Swierzawa,
// z tabeli harnas_ranking) - z kolejnych dni panel /admin/przekierowania wylicza dzienne przyrosty glosow.
// Gdy ktorakolwiek jednostka zyska co najmniej HARNAS_ALERT_PROG glosow od ostatniego powiadomienia,
// wysyla e-mail na HARNAS_ALERT_EMAIL (stan w tabeli harnas_konkurencja_alert).
class HarnasKonkurencja extends Command
{
    protected $signature = 'harnas:konkurencja';

    protected $description = 'Zapisuje glosy pierwszych 20 jednostek rankingu osp-harnas.pl';

    // osp-harnas.pl zwraca najwyzej 10 pozycji na strone
    const STRON = 2;

    const STREFA = 'Europe/Warsaw';

    public function handle(): int
    {
        $pozycje = [];
        for ($strona = 1; $strona <= self::STRON; $strona++) {
            if ($strona > 1) {
                sleep(1);
            }
            try {
                $dane = Harnas::pobierzStrone($strona);
            } catch (\Throwable $e) {
                $this->error($e->getMessage());

                return self::FAILURE;
            }
            foreach ($dane['data'] ?? [] as $poz) {
                $pozycje[trim($poz['name'])] = ['pozycja' => (int) $poz['position'], 'glosy' => (int) $poz['vote_count']];
            }
        }

        // OSP Swierzawa poza pierwsza 20 - bierzemy ostatni odczyt strony glownej, o ile jest swiezy
        $my = DB::table('harnas_ranking')->where('id', 1)->first();
        if ($my && $my->pozycja && !isset($pozycje[Harnas::NAZWA]) && $my->aktualizacja >= now()->subHours(2)) {
            $pozycje[Harnas::NAZWA] = ['pozycja' => (int) $my->pozycja, 'glosy' => (int) $my->glosy];
        }

        $dzien = now(self::STREFA)->toDateString();
        foreach ($pozycje as $nazwa => $p) {
            $istniejacy = DB::table('harnas_konkurencja')->where('data', $dzien)->where('nazwa', $nazwa)->exists();
            if ($istniejacy) {
                DB::table('harnas_konkurencja')->where('data', $dzien)->where('nazwa', $nazwa)
                    ->update($p + ['updated_at' => now()]);
            } else {
                DB::table('harnas_konkurencja')->insert($p + ['data' => $dzien, 'nazwa' => $nazwa, 'glosy_rano' => $p['glosy'], 'updated_at' => now()]);
            }
            $this->line($p['pozycja'].'. '.$nazwa.' - '.$p['glosy']);
        }

        return $this->powiadom($pozycje, $dzien);
    }

    // e-mail o jednostkach, ktore od ostatniego powiadomienia zyskaly co najmniej `prog` glosow;
    // jednostka widziana pierwszy raz dostaje tylko punkt odniesienia (bez powiadomienia)
    private function powiadom(array $pozycje, string $dzien): int
    {
        $email = config('services.harnas.alert_email');
        $prog = max(1, (int) config('services.harnas.alert_prog'));
        if (!$email) {
            return self::SUCCESS;
        }

        $stan = DB::table('harnas_konkurencja_alert')->pluck('glosy', 'nazwa');
        $dzis = DB::table('harnas_konkurencja')->where('data', $dzien)->pluck('glosy_rano', 'nazwa');
        $nowe = [];
        foreach ($pozycje as $nazwa => $p) {
            if (!isset($stan[$nazwa])) {
                DB::table('harnas_konkurencja_alert')->insert(['nazwa' => $nazwa, 'glosy' => $p['glosy'], 'updated_at' => now()]);
            } elseif ($p['glosy'] - $stan[$nazwa] >= $prog) {
                $nowe[$nazwa] = $p + ['przyrost' => $p['glosy'] - $stan[$nazwa], 'dzis' => $p['glosy'] - ($dzis[$nazwa] ?? $p['glosy'])];
            }
        }
        if (!$nowe) {
            return self::SUCCESS;
        }

        uasort($nowe, fn ($a, $b) => $a['pozycja'] <=> $b['pozycja']);
        $tresc = 'Nowe glosy w rankingu osp-harnas.pl (prog: '.$prog.'), '.now(self::STREFA)->format('d.m.Y H:i').":\n\n";
        foreach ($nowe as $nazwa => $p) {
            $tresc .= $p['pozycja'].'. '.$nazwa.': +'.$p['przyrost'].' (razem '.$p['glosy'].', dzis od pierwszego odczytu +'.$p['dzis'].")\n";
        }
        $tresc .= "\nStatystyki: ".rtrim(config('app.url'), '/')."/admin/przekierowania\n";

        try {
            Mail::raw($tresc, fn ($m) => $m->to($email)
                ->subject('Harnas: nowe glosy - '.implode(', ', array_map(fn ($n, $p) => $n.' +'.$p['przyrost'], array_keys($nowe), $nowe))));
        } catch (\Throwable $e) {
            // punkt odniesienia bez zmian - sprobujemy przy nastepnym uruchomieniu
            $this->error('Powiadomienie: '.$e->getMessage());

            return self::FAILURE;
        }

        foreach ($nowe as $nazwa => $p) {
            DB::table('harnas_konkurencja_alert')->where('nazwa', $nazwa)->update(['glosy' => $p['glosy'], 'updated_at' => now()]);
        }
        $this->info('Wyslano powiadomienie: '.count($nowe).' jednostek');

        return self::SUCCESS;
    }
}
