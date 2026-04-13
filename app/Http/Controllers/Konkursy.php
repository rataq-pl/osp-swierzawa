<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class Konkursy extends Controller
{
    public function wyslijWyniki(){
        if($_POST['klucz'] == '1fawtt5eaf'){
            $sql = DB::table('testy_wyniki')->where('id', $_POST['idTestu'])->first();
            $sql2 = DB::table('testy_wysylka_wynikow')->where('testy_id', $_POST['idTestu'])->get();
            if(count($sql2) > 0){

            }else{
            DB::table('testy_wysylka_wynikow')->insert([
                'id' => null,
                'testy_id' => $_POST['idTestu'],
                'dodano' => date("Y-m-d H:i:s")
            ]);
            //Konkursy::wysylkaWynikow();
        }
            return ['status' => true];
        }
    }
    public function oznaczGotowy(){
        if($_POST['klucz'] == '1fa2wtteaf'){
            $idTestu = $_POST['idTestu'];
            $sql = DB::table('testy_wyniki')->where('id', $idTestu)->first();
            $odpowiedziUdzielone = explode(',,,,,', $sql -> odpowiedzi_udzielone);
            $wlasciweOdpowiedzi = explode(',,,,,', $sql -> wlasciwe_odpowiedzi);
            $tablicaUdzielonych = [];
            for($i=0;$i<count($odpowiedziUdzielone);$i++){
                $teraz = explode(':::::', $odpowiedziUdzielone[$i]);
                $odpowiedziano = explode('-', $teraz[1]);
                $odpowiedziano = $odpowiedziano[1];
                array_push($tablicaUdzielonych, [
                    'numerPytania' => $teraz[0],
                    'odpowiedziano' => $odpowiedziano
                ]);
            }
            $tablicaPoprawnych = [];
            for($i=0;$i<count($wlasciweOdpowiedzi);$i++){
                $teraz = explode(':::::', $wlasciweOdpowiedzi[$i]);
                array_push($tablicaPoprawnych, $teraz[1]);
            }
            $wszystkich = count($tablicaUdzielonych);
            $liczymy = 0;
            for($i=0;$i<$wszystkich;$i++){
                if($tablicaUdzielonych[$i]['odpowiedziano'] == $tablicaPoprawnych[$i]){
                    $liczymy++;
                }else{
                    $liczymy = $liczymy;
                }
            }
            $procent = $liczymy / $wszystkich;
            $procent = round($procent * 100);
            $wynikDB = $procent.'%';
            $wynikDB = explode('!', $wynikDB);
            $wynikDB = $wynikDB[0];
           
            return [
                'punkty' => $liczymy,
                'naIle' => $wszystkich,
                'procent' => $procent,
                'mail' => $sql -> mail
            ];
        }

    }
    public function aktualizujOdpowiedzi(){
        if($_POST['klucz'] == '1fawtteaf'){
            $idTestu = $_POST['idTestu'];
            $mozliwosciWyboru = $_POST['numerPytania'].':::::'.$_POST['mozliwosciWyboru'];
            $udzielonaOdpowiedz = $_POST['numerPytania'].':::::'.$_POST['idWybranego'];
            $sql = DB::table('testy_wyniki')->where('id', $idTestu)->first();
            if($sql -> odpowiedzi_udzielone == ''){
                $udzielonaOdpowiedz = $udzielonaOdpowiedz;
                $mozliwosciWyboru = $mozliwosciWyboru;
            }else{
                $udzielonaOdpowiedz = $sql -> odpowiedzi_udzielone.',,,,,'.$udzielonaOdpowiedz;
                $mozliwosciWyboru = $sql -> mozliwosci_wyboru.'-----'.$mozliwosciWyboru;
            }
            //pobieramy prawidłowe odpowiedzi
                $pytaniaZadane = explode('----------', $sql -> pytania_zadane);
                $listaOdpowiedzi = '';
                for($i=0;$i<count($pytaniaZadane);$i++){
                    $odpowiedz = DB::table('testy_pytania')->where('pytanie', $pytaniaZadane[$i])->first();
                    if($listaOdpowiedzi == ''){
                        $listaOdpowiedzi = $i.':::::'.$odpowiedz -> prawidlowa;
                    }else{
                        $listaOdpowiedzi = $listaOdpowiedzi.',,,,,'.$i.':::::'.$odpowiedz -> prawidlowa;
                    }
                }
            $sql = DB::table('testy_wyniki')->where('id', $idTestu)->update([
                'odpowiedzi_udzielone' => $udzielonaOdpowiedz,
                'mozliwosci_wyboru' => $mozliwosciWyboru,
                'wlasciwe_odpowiedzi' => $listaOdpowiedzi
            ]);
            return [
                'idTestu' => $idTestu,
                'status' => 'zmiana',
                'wynik' => 'ok'
            ];
        }
    }
    public function startPytan(){
        if($_POST['klucz'] == 'afsavnvkjg'){
            $email = $_POST['email'];
            $zadane = $_POST['url'];
            $ip = $_POST['ip'];
            $sql = DB::table('testy_wyniki')->insert([
                'id' => null,
                'mail' => $email,
                'nowePytania' => null,
                'noweDzialania' => null,
                'noweWydarzenia' => null,
                'pytania_zadane' => $zadane,
                'odpowiedzi_udzielone' => '', 
                'wynikKoncowy' => null,
                'ip' => $ip
            ]);
            $sql = DB::table('testy_wyniki')->orderByDesc('id')->first();
            return [
                'status' => true,
                'idTestu' => $sql -> id
            ];
        }
    }
    public function pobierzPytania($url){
        $sql = DB::table('testy')->where('url', $url)->first();
        
        return DB::table('testy_pytania')->where('testy_id', $sql -> id)->inRandomOrder()->limit(10)->get();
    }
    public function konkursyPokaz(){
        $q = DB::table('testy')->where('url', request()->segment(2))->first();
        return view('user.konkursyPokaz', [
            'konkurs' => $q,
            'tytul' => $q -> tytul,
            'pytania' => DB::table('testy_pytania')->where('testy_id', $q -> id)->get()
        ]);
    }
    public function konkursyGlowna(){
        return view('user.konkursyGlowna', [
            'konkursy' => DB::table('testy')->orderByDesc('id')->get(),
            'tytul' => 'Ucz się z nami'
        ]);
    }
}
