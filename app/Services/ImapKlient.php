<?php

namespace App\Services;

// Minimalny klient IMAP po gniezdzie SSL - serwer nie ma rozszerzenia php-imap,
// a potrzebujemy tylko: lista nieprzeczytanych, wyszukanie po Message-ID, pobranie surowej wiadomosci, oznaczenie jako przeczytana.
class ImapKlient
{
    private $gniazdo;
    private int $licznik = 0;

    public function __construct(string $host, int $port, string $login, string $haslo, int $timeout = 30)
    {
        $this->gniazdo = @stream_socket_client('ssl://'.$host.':'.$port, $errno, $errstr, $timeout);
        if (!$this->gniazdo) {
            throw new \Exception('IMAP polaczenie '.$host.':'.$port.' - '.$errstr);
        }
        stream_set_timeout($this->gniazdo, $timeout);
        $this->linia(); // powitanie serwera

        $this->komenda('LOGIN '.$this->cytuj($login).' '.$this->cytuj($haslo));
        $this->komenda('SELECT INBOX');
    }

    // UID-y nieprzeczytanych wiadomosci
    public function nieprzeczytane(): array
    {
        $uidy = [];
        foreach ($this->komenda('UID SEARCH UNSEEN') as $wiersz) {
            if (preg_match('/^\* SEARCH ?(.*)$/', $wiersz, $m)) {
                $uidy = array_merge($uidy, array_filter(explode(' ', trim($m[1]))));
            }
        }

        return array_map('intval', $uidy);
    }

    // UID-y wiadomosci pasujacych do kryteriow IMAP SEARCH (np. 'SINCE 27-Nov-2026 FROM "domena.pl"')
    public function szukaj(string $kryteria): array
    {
        $uidy = [];
        foreach ($this->komenda('UID SEARCH '.$kryteria) as $wiersz) {
            if (is_string($wiersz) && preg_match('/^\* SEARCH ?(.*)$/', $wiersz, $m)) {
                $uidy = array_merge($uidy, array_filter(explode(' ', trim($m[1]))));
            }
        }

        return array_map('intval', $uidy);
    }

    // cala wiadomosc (naglowki + tresc); BODY.PEEK nie ustawia flagi \Seen
    public function pobierz(int $uid): string
    {
        foreach ($this->komenda('UID FETCH '.$uid.' BODY.PEEK[]') as $wiersz) {
            if (is_array($wiersz)) {
                return $wiersz['literal'];
            }
        }

        throw new \Exception('IMAP brak tresci wiadomosci UID '.$uid);
    }

    // UID wiadomosci o podanym naglowku Message-ID (null gdy zostala usunieta ze skrzynki)
    public function szukajMessageId(string $messageId): ?int
    {
        foreach ($this->komenda('UID SEARCH HEADER Message-ID '.$this->cytuj($messageId)) as $wiersz) {
            if (is_string($wiersz) && preg_match('/^\* SEARCH (\d+)/', $wiersz, $m)) {
                return (int) $m[1];
            }
        }

        return null;
    }

    // trwale usuwa z INBOX wiadomosci odebrane przed $granica (z dokladnoscia do sekundy), najwyzej $limit
    // naraz (0 = wszystkie) - przy tysiacach maili panel wola kilka razy, zeby zadanie nie przekroczylo czasu.
    // Zwraca ['usunieto' => ile teraz, 'pozostalo' => ile jeszcze czeka]. $suchyBieg = true tylko liczy.
    public function usunStarsze(\DateTimeInterface $granica, int $limit = 0, bool $suchyBieg = false): array
    {
        // SEARCH BEFORE porownuje same daty (wg strefy serwera) - kandydatow bierzemy z zapasem dnia,
        // dokladna godzine sprawdzamy po INTERNALDATE
        $dzienPo = \DateTimeImmutable::createFromInterface($granica)->modify('+2 days')->format('d-M-Y');
        $starsze = [];
        foreach ($this->daty($this->szukaj('BEFORE '.$dzienPo.' NOT DELETED')) as $uid => $odebrano) {
            if ($odebrano < $granica) {
                $starsze[] = $uid;
            }
        }
        sort($starsze);
        $teraz = $limit > 0 ? array_slice($starsze, 0, $limit) : $starsze;
        if ($teraz && !$suchyBieg) {
            foreach (array_chunk($teraz, 500) as $partia) {
                $this->komenda('UID STORE '.self::zbior($partia).' +FLAGS.SILENT (\Deleted)');
            }
            $this->komenda('EXPUNGE');
        }

        return ['usunieto' => count($teraz), 'pozostalo' => count($starsze) - count($teraz)];
    }

    // uid => data odebrania (INTERNALDATE) dla podanych UID-ow
    public function daty(array $uidy): array
    {
        $daty = [];
        foreach (array_chunk($uidy, 1000) as $partia) {
            foreach ($this->komenda('UID FETCH '.self::zbior($partia).' (UID INTERNALDATE)') as $wiersz) {
                if (is_string($wiersz) && ($wynik = self::parsujDate($wiersz))) {
                    $daty[$wynik[0]] = $wynik[1];
                }
            }
        }

        return $daty;
    }

    // "* 5 FETCH (UID 12 INTERNALDATE "27-Nov-2026 09:22:16 +0100")" -> [12, DateTimeImmutable]
    public static function parsujDate(string $wiersz): ?array
    {
        if (preg_match('/^\* \d+ FETCH \(.*UID (\d+)/', $wiersz, $u) && preg_match('/INTERNALDATE "([^"]+)"/', $wiersz, $d)) {
            $data = \DateTimeImmutable::createFromFormat('j-M-Y H:i:s O', trim($d[1]));
            if ($data) {
                return [(int) $u[1], $data];
            }
        }

        return null;
    }

    // [1,2,3,7,9,10] -> "1:3,7,9:10" - krotsze komendy przy tysiacach wiadomosci
    public static function zbior(array $uidy): string
    {
        $uidy = array_values(array_unique(array_map('intval', $uidy)));
        sort($uidy);
        $zakresy = [];
        $start = $poprzedni = null;
        foreach ($uidy as $uid) {
            if ($poprzedni !== null && $uid === $poprzedni + 1) {
                $poprzedni = $uid;
                continue;
            }
            if ($start !== null) {
                $zakresy[] = $start === $poprzedni ? (string) $start : $start.':'.$poprzedni;
            }
            $start = $poprzedni = $uid;
        }
        if ($start !== null) {
            $zakresy[] = $start === $poprzedni ? (string) $start : $start.':'.$poprzedni;
        }

        return implode(',', $zakresy);
    }

    public function oznaczPrzeczytana(int $uid): void
    {
        $this->komenda('UID STORE '.$uid.' +FLAGS.SILENT (\Seen)');
    }

    public function rozlacz(): void
    {
        if ($this->gniazdo) {
            try {
                $this->komenda('LOGOUT');
            } catch (\Exception $e) {
            }
            fclose($this->gniazdo);
            $this->gniazdo = null;
        }
    }

    public function __destruct()
    {
        $this->rozlacz();
    }

    // wysyla komende i zwraca odpowiedzi nieoznaczone; literaly {n} zwracane jako ['literal' => ...]
    private function komenda(string $komenda): array
    {
        $tag = 'A'.(++$this->licznik);
        fwrite($this->gniazdo, $tag.' '.$komenda."\r\n");

        $odpowiedzi = [];
        while (true) {
            $wiersz = $this->linia();
            if (str_starts_with($wiersz, $tag.' ')) {
                if (!preg_match('/^'.$tag.' OK/i', $wiersz)) {
                    $pokaz = str_starts_with($komenda, 'LOGIN') ? 'LOGIN' : $komenda;
                    throw new \Exception('IMAP '.$pokaz.': '.$wiersz);
                }

                return $odpowiedzi;
            }
            if (preg_match('/\{(\d+)\}$/', $wiersz, $m)) {
                $odpowiedzi[] = ['naglowek' => $wiersz, 'literal' => $this->czytaj((int) $m[1])];
                continue;
            }
            $odpowiedzi[] = $wiersz;
        }
    }

    private function linia(): string
    {
        $wiersz = fgets($this->gniazdo);
        if ($wiersz === false) {
            throw new \Exception('IMAP serwer zamknal polaczenie');
        }

        return rtrim($wiersz, "\r\n");
    }

    private function czytaj(int $bajty): string
    {
        $dane = '';
        while (strlen($dane) < $bajty) {
            $kawalek = fread($this->gniazdo, $bajty - strlen($dane));
            if ($kawalek === false || $kawalek === '') {
                throw new \Exception('IMAP przerwany odczyt wiadomosci');
            }
            $dane .= $kawalek;
        }

        return $dane;
    }

    private function cytuj(string $tekst): string
    {
        return '"'.addcslashes($tekst, '"\\').'"';
    }
}
