<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

// Ustawienia skrzynek, z ktorych program harnas-potwierdzanie otwiera linki (boksy "do otwarcia"
// w /admin/przekierowania). Zapisywane w storage/app/harnas-skrzynki.json, haslo zaszyfrowane kluczem aplikacji.
class HarnasSkrzynki
{
    const PLIK = 'harnas-skrzynki.json';

    const DOMYSLNE = [
        'host' => 'h50.seohost.pl',
        'port' => 993,
        'skrzynki' => ['harnas@konvy.pl', 'harnas@prpanel.pl'],
        'nadawca' => 'osp-harnas.pl',
        'haslo' => '',
    ];

    // ustawienia z odszyfrowanym haslem
    public static function wczytaj(): array
    {
        $dane = self::DOMYSLNE;
        if (Storage::disk('local')->exists(self::PLIK)) {
            $plik = json_decode(Storage::disk('local')->get(self::PLIK), true) ?: [];
            $dane = array_merge($dane, array_intersect_key($plik, $dane));
            try {
                $dane['haslo'] = $dane['haslo'] !== '' ? Crypt::decryptString($dane['haslo']) : '';
            } catch (\Exception $e) {
                $dane['haslo'] = ''; // zmieniony APP_KEY - haslo trzeba wpisac ponownie
            }
        }
        $dane['skrzynki'] = array_values(array_pad(array_slice((array) $dane['skrzynki'], 0, 2), 2, ''));

        return $dane;
    }

    // puste haslo = zostaw dotychczasowe
    public static function zapisz(array $nowe): void
    {
        $dane = array_merge(self::wczytaj(), $nowe);
        if (($nowe['haslo'] ?? '') === '') {
            $dane['haslo'] = self::wczytaj()['haslo'];
        }
        $dane['haslo'] = $dane['haslo'] !== '' ? Crypt::encryptString($dane['haslo']) : '';
        Storage::disk('local')->put(self::PLIK, json_encode($dane, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    // polaczenie z i-ta skrzynka (0 lub 1)
    public static function polacz(int $i, int $timeout = 10): ImapKlient
    {
        $u = self::wczytaj();
        if (empty($u['skrzynki'][$i]) || $u['haslo'] === '') {
            throw new \Exception('Uzupełnij ustawienia skrzynek (adres i hasło).');
        }

        return new ImapKlient($u['host'], (int) $u['port'], $u['skrzynki'][$i], $u['haslo'], $timeout);
    }
}
