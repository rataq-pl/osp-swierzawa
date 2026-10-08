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
            app(Glowna::class)->wysylkaWynikow();
        }
            return ['status' => true];
        }
    }
    // Odpowiedzi zapisywane są w kolejności klikania, a nie pytań - wszystko
    // dopasowujemy więc po numerze pytania (indeks w pytania_zadane).
    public static function wynikiTestu($wynik){
        $pytania = explode('----------', $wynik -> pytania_zadane);

        $udzielone = [];
        foreach(array_filter(explode(',,,,,', (string) $wynik -> odpowiedzi_udzielone)) as $wpis){
            $wpis = explode(':::::', $wpis);
            $odp = explode('-', $wpis[1] ?? '');
            $udzielone[(int) $wpis[0]] = isset($odp[1]) ? (int) $odp[1] : null;
        }

        $mozliwosci = [];
        foreach(array_filter(explode('-----', (string) $wynik -> mozliwosci_wyboru)) as $wpis){
            $wpis = explode(':::::', $wpis, 2);
            $mozliwosci[(int) $wpis[0]] = explode(',,,,,', $wpis[1] ?? '');
        }

        $wlasciwe = [];
        foreach(array_filter(explode(',,,,,', (string) $wynik -> wlasciwe_odpowiedzi)) as $wpis){
            $wpis = explode(':::::', $wpis);
            $wlasciwe[(int) $wpis[0]] = (int) ($wpis[1] ?? -1);
        }

        $lista = [];
        $punkty = 0;
        foreach($pytania as $i => $pytanie){
            $udzielona = $udzielone[$i] ?? null;
            $prawidlowa = $wlasciwe[$i] ?? null;
            $dobrze = $udzielona !== null && $udzielona === $prawidlowa;
            if($dobrze){
                $punkty++;
            }
            $lista[] = [
                'pytanie' => trim($pytanie),
                'odpowiedzi' => $mozliwosci[$i] ?? [],
                'udzielona' => $udzielona,
                'prawidlowa' => $prawidlowa,
                'dobrze' => $dobrze,
            ];
        }
        $naIle = count($pytania);

        return [
            'lista' => $lista,
            'punkty' => $punkty,
            'naIle' => $naIle,
            'procent' => $naIle > 0 ? (int) round($punkty / $naIle * 100) : 0,
        ];
    }
    public function oznaczGotowy(){
        if($_POST['klucz'] == '1fa2wtteaf'){
            $sql = DB::table('testy_wyniki')->where('id', $_POST['idTestu'])->first();
            $wyniki = Konkursy::wynikiTestu($sql);

            return [
                'punkty' => $wyniki['punkty'],
                'naIle' => $wyniki['naIle'],
                'procent' => $wyniki['procent'],
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
        abort_if(!$sql, 404);

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
