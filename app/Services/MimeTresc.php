<?php

namespace App\Services;

// Prosty rozbior wiadomosci MIME do podgladu w panelu: naglowki, tresc HTML / tekstowa i nazwy zalacznikow.
// Serwer nie ma rozszerzenia mailparse, a do podgladu wystarczy przejscie po czesciach multipart.
class MimeTresc
{
    const MAKS_GLEBOKOSC = 10;

    // ['naglowki' => [nazwa => wartosc], 'html' => ?string, 'tekst' => ?string, 'zalaczniki' => [nazwa, ...]]
    public static function rozbierz(string $surowa): array
    {
        $wynik = ['naglowki' => self::podziel($surowa)[0], 'html' => null, 'tekst' => null, 'zalaczniki' => []];
        self::czesc($surowa, $wynik, 0);

        return $wynik;
    }

    // linki http(s) z tresci: [['tekst' => opis linku, 'url' => adres], ...] bez powtorzen
    public static function linki(?string $html, ?string $tekst): array
    {
        $linki = [];
        if ($html) {
            $dom = new \DOMDocument();
            @$dom->loadHTML('<?xml encoding="utf-8">'.$html);
            foreach ($dom->getElementsByTagName('a') as $a) {
                $url = trim($a->getAttribute('href'));
                if (preg_match('#^https?://#i', $url)) {
                    $opis = trim(preg_replace('/\s+/u', ' ', $a->textContent)) ?: trim($a->getAttribute('title'));
                    $linki[$url] ??= ['tekst' => $opis, 'url' => $url];
                }
            }
        } elseif ($tekst && preg_match_all('#https?://[^\s<>"\']+#i', $tekst, $m)) {
            foreach ($m[0] as $url) {
                $url = rtrim($url, '.,;)');
                $linki[$url] ??= ['tekst' => '', 'url' => $url];
            }
        }

        return array_values($linki);
    }

    public static function dekodujNaglowek(string $tekst): string
    {
        return trim(str_contains($tekst, '=?') ? mb_decode_mimeheader($tekst) : $tekst);
    }

    private static function czesc(string $surowa, array &$wynik, int $glebokosc): void
    {
        [$naglowki, $tresc] = self::podziel($surowa);
        $typ = strtolower(trim(strtok(($naglowki['content-type'] ?? '') ?: 'text/plain', ';')));
        $granica = self::parametr($naglowki['content-type'] ?? '', 'boundary');

        if (str_starts_with($typ, 'multipart/') && $granica && $glebokosc < self::MAKS_GLEBOKOSC) {
            $czesci = preg_split('/\r?\n--'.preg_quote($granica, '/').'(--)?[ \t]*(?=\r?\n|$)/', "\n".$tresc);
            array_shift($czesci); // preambula przed pierwsza granica
            foreach ($czesci as $c) {
                $c = preg_replace('/^\r?\n/', '', $c);
                if (trim($c) !== '') {
                    self::czesc($c, $wynik, $glebokosc + 1);
                }
            }

            return;
        }

        $nazwa = self::parametr($naglowki['content-disposition'] ?? '', 'filename')
            ?? self::parametr($naglowki['content-type'] ?? '', 'name');
        $zalacznik = str_starts_with(strtolower($naglowki['content-disposition'] ?? ''), 'attachment');
        if ($nazwa || $zalacznik || !in_array($typ, ['text/html', 'text/plain'])) {
            $wynik['zalaczniki'][] = self::dekodujNaglowek($nazwa ?? $typ);

            return;
        }

        $tresc = match (strtolower(trim($naglowki['content-transfer-encoding'] ?? ''))) {
            'base64' => base64_decode(preg_replace('/\s+/', '', $tresc)),
            'quoted-printable' => quoted_printable_decode($tresc),
            default => $tresc,
        };
        $kodowanie = self::parametr($naglowki['content-type'] ?? '', 'charset');
        if ($kodowanie && strcasecmp($kodowanie, 'utf-8') !== 0) {
            try {
                $tresc = mb_convert_encoding($tresc, 'UTF-8', $kodowanie);
            } catch (\ValueError $e) {
                // nieznane kodowanie - zostawiamy jak jest
            }
        }

        $klucz = $typ == 'text/html' ? 'html' : 'tekst';
        $wynik[$klucz] ??= $tresc;
    }

    // [naglowki (nazwa malymi literami => ostatnia wartosc), tresc]
    private static function podziel(string $surowa): array
    {
        $podzial = preg_split('/\r?\n\r?\n/', $surowa, 2);
        $naglowki = [];
        foreach (preg_split('/\r?\n(?![ \t])/', $podzial[0]) as $wiersz) {
            if (str_contains($wiersz, ':')) {
                [$nazwa, $wartosc] = explode(':', $wiersz, 2);
                $naglowki[strtolower(trim($nazwa))] = trim(preg_replace('/\r?\n[ \t]+/', ' ', $wartosc));
            }
        }

        return [$naglowki, $podzial[1] ?? ''];
    }

    private static function parametr(string $naglowek, string $nazwa): ?string
    {
        // filename*=UTF-8''nazwa%20pliku.pdf (RFC 2231)
        if (preg_match('/\b'.$nazwa.'\*=([^\']*)\'[^\']*\'([^;\s]+)/i', $naglowek, $m)) {
            return rawurldecode($m[2]);
        }

        return preg_match('/\b'.$nazwa.'="?([^";]+)"?/i', $naglowek, $m) ? trim($m[1]) : null;
    }
}
