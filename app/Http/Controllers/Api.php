<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Api extends Controller
{
    public function pobierzPodstrone(){
        $input = file_get_contents('php://input');
        $input = json_decode($input);
        $pobierz = $input -> pobierz;
        if($pobierz == 'historia'){
            $sql = DB::table('podstrony')->where('url', 'historia')->first();
        }elseif($pobierz == 'wyposazenie'){
            $sql = DB::table('podstrony')->where('url', 'wyposazenie')->first();
        }elseif($pobierz == 'polityka-prywatnosci'){
            $sql = DB::table('podstrony')->where('url', 'polityka-prywatnosci')->first();
        }elseif($pobierz == 'statut'){
            $sql = DB::table('podstrony')->where('url', 'statut')->first();
        }
        return json_encode([
            'co' => $pobierz,
            'tytul' => $sql ->tytul,
            'tresc' => str_replace('src="', 'src="https://osp-swierzawa.pl', $sql ->tresc),
            'zdjecie' => $sql ->zdjecie
        ]);
    }
    public function pokazWpisyAplikacja(){
        $input = file_get_contents('php://input');
        $input = json_decode($input);
        $pomin = $input -> pomin;
        $sql = DB::table('aktualnosci')->orderByDesc('id')->limit(5)->offset($pomin)->get();
        $podajemy = count($sql);
        return json_encode([
            'pomin' => $input -> pomin,
            'podajemy' => $podajemy,
            'wpisy' => $sql
        ]);
    }
    public static function tytulStrony(){
        return 'Ochotnicza Straż Pożarna w Świerzawie';
    }
}
