<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Harnas extends Controller
{
    const URL = 'https://osp-harnas.pl';
    const NAZWA = 'Świerzawa';
    const CO_ILE = 600; // najwyzej jedna proba pobrania na 10 min, niezaleznie od liczby odwiedzajacych

    // GET /ranking-harnas - pozycja OSP Swierzawa w rankingu osp-harnas.pl
    // Wynik trzymany jest w tabeli harnas_ranking (jeden wiersz, id = 1)
    public function ranking(){
        // atomowy UPDATE - tylko pierwsze zapytanie w danym oknie 10 min pobiera dane,
        // pozostali odwiedzajacy dostaja zapisany wynik (rowniez gdy pobranie sie nie udalo)
        $mojaProba = DB::table('harnas_ranking')
            ->where('id', 1)
            ->where(function($q){
                $q->whereNull('proba')->orWhere('proba', '<', now()->subSeconds(self::CO_ILE));
            })
            ->update(['proba' => now()]);

        if($mojaProba){
            try{
                DB::table('harnas_ranking')->where('id', 1)->update($this->pobierzRanking() + ['blad' => null]);
            }catch(\Throwable $e){
                Log::warning('Ranking Harnas: '.$e->getMessage());
                DB::table('harnas_ranking')->where('id', 1)->update(['blad' => mb_substr($e->getMessage(), 0, 250)]);
            }
        }

        $q = DB::table('harnas_ranking')->where('id', 1)->first();
        if(!$q || !$q->pozycja){
            return response()->json(['blad' => $q->blad ?? 'Brak danych'], 503);
        }
        return response()->json([
            'pozycja' => $q->pozycja,
            'glosy' => $q->glosy,
            // ile glosow brakuje do kolejnego miejsca (null = 1. miejsce lub brak danych)
            'brakuje' => $q->pozycja > 1 && isset($q->glosy_wyzej) ? max(1, $q->glosy_wyzej - $q->glosy + 1) : null,
            'wszystkich' => $q->wszystkich,
            'aktualizacja' => Carbon::parse($q->aktualizacja, 'UTC')->toIso8601String(),
            'blad' => $q->blad,
        ])->header('Cache-Control', 'no-store');
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
        $q = DB::table('harnas_ranking')->where('id', 1)->first();
        $start = $q->start ?? $q->strona ?? 20;
        $kolejnosc = array_values(array_unique(array_filter(
            [$start, $start - 1, $start + 1],
            fn($strona) => $strona >= 1
        )));

        $ostatniaStrona = null;
        $zapytan = 0;
        foreach($kolejnosc as $strona){
            if($ostatniaStrona && $strona > $ostatniaStrona){
                continue;
            }
            if($ostatniaStrona){
                sleep(1);
            }
            $dane = $this->pobierzStrone($strona);
            $zapytan++;
            $ostatniaStrona = $dane['last_page'] ?? null;
            foreach($dane['data'] ?? [] as $i => $poz){
                if(mb_strtolower(trim($poz['name'])) == mb_strtolower(self::NAZWA)){
                    // jednostka bezposrednio wyzej w rankingu
                    $glosyWyzej = $this->glosyWyzej(array_slice($dane['data'], 0, $i));
                    // jestesmy na gorze strony - zagladamy na poprzednia, o ile nie przekroczymy limitu 3 zapytan
                    if($glosyWyzej === null && $poz['position'] > 1 && $strona > 1 && $zapytan < 3){
                        sleep(1);
                        $poprzednia = $this->pobierzStrone($strona - 1);
                        $glosyWyzej = $this->glosyWyzej($poprzednia['data'] ?? []);
                    }
                    return [
                        'pozycja' => $poz['position'],
                        'glosy' => $poz['vote_count'],
                        'glosy_wyzej' => $glosyWyzej,
                        'strona' => $strona,
                        'wszystkich' => $dane['total'] ?? null,
                        'start' => null,
                        'aktualizacja' => now(),
                    ];
                }
            }
        }
        $nastepny = min($kolejnosc) - 1;
        DB::table('harnas_ranking')->where('id', 1)->update(['start' => $nastepny >= 1 ? $nastepny : ($ostatniaStrona ?? 20)]);
        throw new \Exception('nie znaleziono '.self::NAZWA.' na stronach '.implode(',', $kolejnosc));
    }

    // liczba glosow ostatniej pozycji z listy (czyli tej tuz nad nami)
    private function glosyWyzej(array $pozycje){
        $wyzej = end($pozycje);
        return $wyzej ? (int) $wyzej['vote_count'] : null;
    }
}
