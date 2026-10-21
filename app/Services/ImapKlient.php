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
