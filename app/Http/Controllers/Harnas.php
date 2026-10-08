<?php

namespace App\Http\Controllers;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Harnas extends Controller
{
    const URL = 'https://osp-harnas.pl';
    const NAZWA = 'Świerzawa';
    const CO_ILE = 600; // najwyzej jedna proba pobrania na 10 min, niezaleznie od liczby odwiedzajacych

    // GET /ranking-harnas - pozycja OSP Swierzawa w rankingu osp-harnas.pl
    public function ranking(){
        // Cache::add jest atomowe - tylko pierwsze zapytanie w danym oknie 10 min pobiera dane,
        // pozostali odwiedzajacy dostaja zapamietany wynik (rowniez gdy pobranie sie nie udalo)
        if(Cache::add('harnas_ranking_proba', now()->timestamp, self::CO_ILE)){
            try{
                Cache::forever('harnas_ranking_ostatni', $this->pobierzRanking());
            }catch(\Throwable $e){
                Log::warning('Ranking Harnas: '.$e->getMessage());
            }
        }

        $wynik = Cache::get('harnas_ranking_ostatni');
        if(!$wynik){
            return response()->json(['blad' => 'Brak danych'], 503);
        }
        return response()->json($wynik)->header('Cache-Control', 'no-store');
    }

    private function pobierzRanking(){
        $jar = new CookieJar();
        $http = Http::withOptions(['cookies' => $jar])
            ->withUserAgent('Mozilla/5.0 (OSP Swierzawa ranking)')
            ->timeout(10);

        // API wymaga sesji i tokenu CSRF ze strony glownej
        $glowna = $http->get(self::URL.'/');
        if(!preg_match('/name="csrf-token" content="([^"]+)"/', $glowna->body(), $m)){
            throw new \Exception('brak tokenu CSRF, strona glowna HTTP '.$glowna->status());
        }
        $token = $m[1];

        $pobierzStrone = function($strona) use ($http, $token){
            $odp = $http->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'X-CSRF-TOKEN' => $token,
            ])->post(self::URL.'/api/ranking', ['page' => $strona, 'per_page' => 10]);
            if(!$odp->successful()){
                throw new \Exception('api/ranking HTTP '.$odp->status());
            }
            return $odp->json();
        };

        // zaczynamy od ostatnio znanej strony i szukamy na przemian w gore i w dol
        $ostatni = Cache::get('harnas_ranking_ostatni');
        $start = $ostatni['strona'] ?? 20;
        $pierwsza = $pobierzStrone($start);
        $ostatniaStrona = $pierwsza['last_page'] ?? $start;
        $kolejnosc = [$start];
        for($i = 1; $i <= $ostatniaStrona; $i++){
            if($start - $i >= 1) $kolejnosc[] = $start - $i;
            if($start + $i <= $ostatniaStrona) $kolejnosc[] = $start + $i;
        }

        foreach($kolejnosc as $strona){
            $dane = $strona == $start ? $pierwsza : $pobierzStrone($strona);
            foreach($dane['data'] ?? [] as $poz){
                if(mb_strtolower(trim($poz['name'])) == mb_strtolower(self::NAZWA)){
                    return [
                        'pozycja' => $poz['position'],
                        'glosy' => $poz['vote_count'],
                        'strona' => $strona,
                        'wszystkich' => $dane['total'] ?? null,
                        'aktualizacja' => now()->toIso8601String(),
                    ];
                }
            }
        }
        throw new \Exception('nie znaleziono '.self::NAZWA.' w rankingu');
    }
}
