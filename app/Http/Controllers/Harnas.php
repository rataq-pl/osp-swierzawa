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

    // pobiera jedna strone rankingu; osp-harnas.pl przyjmuje tylko jedno zapytanie o ranking
    // na sesje (kolejne konczy sie 419), dlatego kazda strona to nowa sesja
    private function pobierzStrone($strona){
        $jar = new CookieJar();
        $http = Http::withOptions(['cookies' => $jar])
            ->withUserAgent('Mozilla/5.0 (OSP Swierzawa ranking)')
            ->timeout(10);

        $glowna = $http->get(self::URL.'/');
        $xsrf = $jar->getCookieByName('XSRF-TOKEN');
        if(!$xsrf){
            throw new \Exception('brak ciasteczka XSRF-TOKEN, strona glowna HTTP '.$glowna->status());
        }

        $odp = $http->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
            'X-XSRF-TOKEN' => urldecode($xsrf->getValue()),
        ])->post(self::URL.'/api/ranking', ['page' => $strona, 'per_page' => 10]);
        if(!$odp->successful()){
            throw new \Exception('api/ranking strona '.$strona.' HTTP '.$odp->status());
        }
        return $odp->json();
    }

    private function pobierzRanking(){
        // zaczynamy od ostatnio znanej strony; glosow tylko przybywa, wiec szukamy glownie w gore rankingu
        // (mniejsze numery stron). Najwyzej 3 strony na probe (osp-harnas.pl blokuje IP przy wiekszej liczbie zapytan);
        // jesli nie znajdziemy, kolejna proba zaczyna tam, gdzie skonczyla ta.
        $ostatni = Cache::get('harnas_ranking_ostatni');
        $start = Cache::get('harnas_ranking_start', $ostatni['strona'] ?? 20);
        $kolejnosc = array_values(array_unique(array_filter(
            [$start, $start - 1, $start + 1],
            fn($strona) => $strona >= 1
        )));

        $ostatniaStrona = null;
        foreach($kolejnosc as $strona){
            if($ostatniaStrona && $strona > $ostatniaStrona){
                continue;
            }
            if($ostatniaStrona){
                sleep(1);
            }
            $dane = $this->pobierzStrone($strona);
            $ostatniaStrona = $dane['last_page'] ?? null;
            foreach($dane['data'] ?? [] as $poz){
                if(mb_strtolower(trim($poz['name'])) == mb_strtolower(self::NAZWA)){
                    Cache::forget('harnas_ranking_start');
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
        $nastepny = min($kolejnosc) - 1;
        Cache::forever('harnas_ranking_start', $nastepny >= 1 ? $nastepny : ($ostatniaStrona ?? 20));
        throw new \Exception('nie znaleziono '.self::NAZWA.' na stronach '.implode(',', $kolejnosc));
    }
}
