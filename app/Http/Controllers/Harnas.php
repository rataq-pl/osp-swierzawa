<?php

namespace App\Http\Controllers;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Harnas extends Controller
{
    const URL = 'https://osp-harnas.pl';
    const NAZWA = 'Świerzawa';
    const CACHE_CZAS = 120; // 2 min

    // GET /ranking-harnas - pozycja OSP Swierzawa w rankingu osp-harnas.pl
    public function ranking(){
        $wynik = Cache::get('harnas_ranking');
        if(!$wynik){
            try{
                $wynik = $this->pobierzRanking();
            }catch(\Throwable $e){
                $wynik = null;
            }
            if($wynik){
                Cache::put('harnas_ranking', $wynik, self::CACHE_CZAS);
                Cache::forever('harnas_ranking_ostatni', $wynik);
            }else{
                // gdy strona Harnasia nie odpowiada - pokaz ostatni znany wynik
                $wynik = Cache::get('harnas_ranking_ostatni');
            }
        }
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
        $html = $http->get(self::URL.'/')->body();
        if(!preg_match('/name="csrf-token" content="([^"]+)"/', $html, $m)){
            return null;
        }
        $token = $m[1];

        $pobierzStrone = function($strona) use ($http, $token){
            $odp = $http->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'X-CSRF-TOKEN' => $token,
            ])->post(self::URL.'/api/ranking', ['page' => $strona, 'per_page' => 10]);
            return $odp->successful() ? $odp->json() : null;
        };

        // zaczynamy od ostatnio znanej strony i szukamy na przemian w gore i w dol
        $ostatni = Cache::get('harnas_ranking_ostatni');
        $start = $ostatni['strona'] ?? 20;
        $pierwsza = $pobierzStrone($start);
        if(!$pierwsza){
            return null;
        }
        $ostatniaStrona = $pierwsza['last_page'] ?? $start;
        $kolejnosc = [$start];
        for($i = 1; $i <= $ostatniaStrona; $i++){
            if($start - $i >= 1) $kolejnosc[] = $start - $i;
            if($start + $i <= $ostatniaStrona) $kolejnosc[] = $start + $i;
        }

        foreach($kolejnosc as $strona){
            $dane = $strona == $start ? $pierwsza : $pobierzStrone($strona);
            if(!$dane){
                continue;
            }
            foreach($dane['data'] ?? [] as $poz){
                if(mb_strtolower(trim($poz['name'])) == mb_strtolower(self::NAZWA)){
                    return [
                        'pozycja' => $poz['position'],
                        'glosy' => $poz['vote_count'],
                        'strona' => $strona,
                        'wszystkich' => $dane['total'] ?? null,
                        'aktualizacja' => date('Y-m-d H:i'),
                    ];
                }
            }
        }
        return null;
    }
}
