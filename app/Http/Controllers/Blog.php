<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api;

class Blog extends Controller
{
    public function blogWpisy(){
        $sql = DB::table('aktualnosci')->orderByDesc('id')->limit(20)->get();
        $ile = DB::table('aktualnosci')->get();
        return view('user.wpisy', [
            'wpisy' => $sql,
            'tytul' => Api::tytulStrony(),
            'wszystkich' => count($ile),
            'co' => 'Wszystkie wpisy'
        ]);
    }

    public function blogWpisPokaz($url){
        $q = DB::table('aktualnosci')->where('url', $url)->first();
        return view('user.blogPokazWpis', [
            'q' => $q,
            'tytul' => $q -> tytul.' - OSP Świerzawa',
            'co' => $q -> tytul.' - OSP Świerzawa',
            'autor' => DB::table('users')->where('id', $q -> autor)->first(),
            'inne' => DB::table('aktualnosci')->where('kategoria', $q -> kategoria)->where('url', '!=', $url)->orderByDesc('id')->limit(8)->get(),
            'testy' => DB::table('testy')->inRandomOrder()->limit(3)->get(),
            'zdjecia' => DB::table('aktualnosciGalerie')->where('aktualnosciID', $q -> id)->get(),
            'video' => DB::table('aktualnosciWideo')->where('aktualnosciID', $q -> id)->get()
        ]);
    }
    public function dzialaniaRatownicze(){
        $sql = DB::table('aktualnosci')->where('kategoria', 'Zdarzenia')->orderByDesc('id')->limit(12)->get();
        $ile = DB::table('aktualnosci')->where('kategoria', 'Zdarzenia')->get();
        return view('user.wpisy', [
            'wpisy' => $sql,
            'tytul' => Api::tytulStrony(),
            'wszystkich' => count($ile),
            'co' => 'Działania ratownicze'
        ]);
    }
    public function kampanie(){
        $sql = DB::table('aktualnosci')->where('kategoria', 'Kampanie')->orderByDesc('id')->limit(20)->get();
        $ile = DB::table('aktualnosci')->where('kategoria', 'Kampanie')->get();
        return view('user.wpisy', [
            'wpisy' => $sql,
            'tytul' => Api::tytulStrony(),
            'wszystkich' => count($ile),
            'co' => 'Blog'
        ]);
    }
    public function mdp(){
        $sql = DB::table('aktualnosci')->where('kategoria', 'MDP')->orderByDesc('id')->limit(20)->get();
        $ile = DB::table('aktualnosci')->where('kategoria', 'MDP')->get();
        return view('user.wpisy', [
            'wpisy' => $sql,
            'tytul' => Api::tytulStrony(),
            'wszystkich' => count($ile),
            'co' => 'MDP'
        ]);
    }
    public static function tylkoWstep($wstep){
        $wstep = explode(' ', $wstep);
        if(isset($wstep) && isset($wstep[1])){
            $desc = '';
            for($i=0;$i<10;$i++){
                if($desc == ''){
                    $desc = $wstep[$i];
                }else{
                    $desc = $desc.' '.$wstep[$i];
                }
            }
            $desc = str_replace('<p>', '', $desc);
            $desc = explode('<table', $desc);
            $desc = $desc[0];
            $desc = $desc.'(...)';
            return $desc;
        }else{
            return '(...)';
        }
    }
}
