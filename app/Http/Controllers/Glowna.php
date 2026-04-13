<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDO;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
class Glowna extends Controller
{
    public function nowyUser(){
        $hasloNowe = Hash::make('WK');
        $sql = DB::table('users')->where('id', 6)->first();
        DB::table('users')->where('id', 6)->update([
            'password' => $hasloNowe
        ]);
    }
    public static function pokazZdjecieOG(){
        $u1 = request()->segment(1);
        $u2 = request()->segment(2);
        $u3 = request()->segment(3);
        $u4 = request()->segment(4);
        if($u1 == 'konkurs' && $u2 != ''){
            $sql = DB::table('testy')->where('url', $u2)->first();
            echo 'https://osp-swierzawa.pl'.$sql -> zdjecie;
        }elseif($u1 == 'b' && $u2 != ''){
            $sql = DB::table('aktualnosci')->where('url', $u2)->first();
            echo 'https://osp-swierzawa.pl'.$sql -> zdjecie;
            
        }elseif($u1 == 'historia'){
            $sql = DB::table('podstrony')->where('url', 'historia')->first();
            echo 'https://osp-swierzawa.pl'.$sql -> zdjecie;
        }elseif($u1 == 'statut'){
            $sql = DB::table('podstrony')->where('url', 'statut')->first();
            echo 'https://osp-swierzawa.pl'.$sql -> zdjecie;
        }elseif($u1 == 'zbiorka-elektro-smieci-osp-swierzawa'){
            $sql = DB::table('podstrony')->where('url', 'zbiorka-elektro-smieci-osp-swierzawa')->first();
            echo 'https://osp-swierzawa.pl'.$sql -> zdjecie;
        }else{
            echo 'https://osp-swierzawa.pl/upload/osp.jpg';
        }
    }
    public function politykaPrywatnosci(){
        return view('user.politykaPrywatnosci', [
            'q' => DB::table('podstrony')->where('url', 'polityka-prywatnosci')->first(),
            'tytul' => 'Polityka prywatności'
        ]);
    }
    public function wysylkaWynikow(){
        $sql = DB::table('testy_wysylka_wynikow')->select('testy_id')->distinct()->get();
        foreach($sql as $q){
            $idTestu = $q -> testy_id;
            $sql = DB::table('testy_wyniki')->where('id', $idTestu)->first();
            $mail = $sql -> mail;
            $pytania_zadane = explode('----------', $sql -> pytania_zadane);
            $odpowiedzi_udzielone = explode(',,,,,', $sql -> odpowiedzi_udzielone);
            $mozliwosci_wyboru = explode('-----', $sql -> mozliwosci_wyboru);
            $wlasciwe_odpowiedzi = explode(',,,,,', $sql -> wlasciwe_odpowiedzi);
                $odpowiedzi = [];
                for($i=0;$i<count($wlasciwe_odpowiedzi);$i++){
                    $odpTeraz = explode(':::::', $wlasciwe_odpowiedzi[$i]);
                    $nr = $odpTeraz[0];
                    $nr = explode(',', $nr);
                    $nr = $nr[0];
                    array_push($odpowiedzi, $odpTeraz[1]);
                }
                var_dump($odpowiedzi);
                $pytania = [];
                for($j=0;$j<count($pytania_zadane);$j++){
                    array_push($pytania, $pytania_zadane[$j]);
                }
                $udzielone = [];
                for($k=0;$k<count($odpowiedzi_udzielone);$k++){
                    array_push($udzielone, $odpowiedzi_udzielone[$k]);
                }
                $mozliweOdpowiedzi = [];
                for($l=0;$l<count($mozliwosci_wyboru);$l++){
                    $teraz = $mozliwosci_wyboru[$l];
                    $teraz = explode(':::::', $teraz);
                    $numer = $teraz[0];
                    $teraz = str_replace(',,,,,', '<br />', $teraz[1]);
                    $listaMozliwosci = '';
                    
                    array_push($mozliweOdpowiedzi, [
                        $numer => $teraz
                    ]);
                }
            $tabelaStart = '
                <table style="width:100%;">
                    <thead>
                        <th style="background:red; border-right:solid 1px #fff; color:#fff;">Pytanie:</th>
                        <th style="background:red; border-right:solid 1px #fff; color:#fff;">Możliwe odpowiedzi:</th>
                        <th style="background:red; color:#fff;">Prawidłowa odpowiedź:</th>
                        <th style="background:red; color:#fff;">Twoja odpowiedź:</th>
                    </thead>
                    <tbody>
            ';
            $tabelaStop = '
                    </tbody>
                </table>
            ';
            $tabelaTresc = '';
            for($z=0;$z<count($pytania);$z++){
                $prawidlowa = $odpowiedzi[$z];
                if(isset($mozliweOdpowiedzi[$z][$z]) && $mozliweOdpowiedzi[$z][$z] != ''){
                $sprPrawidlowa = explode('<br />', $mozliweOdpowiedzi[$z][$z]);
                $prawidlowa = $sprPrawidlowa[$prawidlowa];
                $udzielona = explode('-', $udzielone[$z]);
                $udzielona = $sprPrawidlowa[$udzielona[1]];
                if($udzielona == $prawidlowa){
                    $kolor = 'cfffd2';
                }else{
                    $kolor = 'ffe9e9';
                }
                $tabelaTresc = $tabelaTresc.'
                    <tr style="background:#'.$kolor.';">
                        <td style="text-align:center; border-bottom: solid 1px red;">'.$pytania[$z].'</td>
                        <td style="text-align:center; border-bottom: solid 1px red;">'.$mozliweOdpowiedzi[$z][$z].'</td>
                        <td style="text-align:center; border-bottom: solid 1px red;">'.$prawidlowa.'</td>
                        <td style="text-align:center; border-bottom: solid 1px red;">'.$udzielona.'</td>
                    </tr>
                ';
                }
            }
            $tabela = $tabelaStart.$tabelaTresc.$tabelaStop;
            $linkLogo = url()->current();
            $linkLogo = str_replace('/api/wysylkaWynikow', '', $linkLogo);
            $linkLogo = $linkLogo.'/assets/images/logo.png';
            $html = '
                <html>
                    <head>
                        <title>Twoje wyniki z testu</title>
                    </head>
                    <body style="padding:5% 25%;">
                        <h5 style="text-align:left; margin-left:5%;">Miło nam, że dołączyłeś do naszych fanów!</h3>
                        <p>
                            W związku z testowaniem swojej wiedzy, pragniemy przesłać Ci listę pytań które nasz system zadał Ci podczas generowania ich.<br />
                            Poniżej w układzie tabelarycznym, przedstawiamy listę pytań, możliwe odpowiedzi podczas testu oraz odpowiedzi które na nie udzieliłeś/aś. Porównaj je i postaraj się zapamiętać aby w kolejnych testach
                            nie robić już tych samych błędów (o ile jakieś popełniłeś/aś :) ).
                        </p>
                        <p>Miłego, sopokojnego i przede wszystkim bezpiecznego dnia!</p>
                        '.$tabela.'
                        <p style="padding-top:5%; text-align:right;">
                        <img src="'.$linkLogo.'" alt="OSP Świerzawa" style="float:right;"/>
                        <div style="width:100%; clear:both;"></div>
                        <h3 style="text-align:right;">Powodzenia kolejnym razem!</h3>
                        </p>
                        <p style="text-align:center; padding-top:10%;">Projekt wykonany przez <a href="https://rataq.pl" style="color:red; text-decoration:none;">RATAQ.PL - Tworzenie i pozycjonowanie stron internetowych</a></p>
                    </body>
                </html>
            ';
            echo $html;
                $temat = 'Twój wirtualny test wiedzy z OSP Świerzawa';
                $do_kogo = $mail;
                Mailing::mail($do_kogo, $temat, $html);
            DB::table('testy_wysylka_wynikow')->where('testy_id', $idTestu)->delete();
        }
        
    }
    public static function tablicaIkon(){
        $tab = [
            'doc' => 'doc.jpg',
            'docx' => 'docx.jpg',
            'jpg' => 'jpg.jpg',
            'pdf' => 'pdf.jpg',
            'xls' => 'xls.jpg',
            'zip' => 'zip.jpg'
        ];
        return $tab;
    }
    public function pobierzStarsze(){
        if($_POST['klucz'] == 'fsa53rasfa'){
            $url = $_POST['url'];
            $pomin = $_POST['pomin'];
            if($url == 'dzialania-ratownicze'){
                $wszystkich = count(DB::table('aktualnosci')->where('kategoria', 'LIKE', 'Zdarzenia')->get());
                $sql = DB::table('aktualnosci')->where('kategoria', 'LIKE', 'Zdarzenia')->orderByDesc('id')->limit(12)->offset($pomin)->get();
                $return = '';
                foreach($sql as $q){
                    $autor = DB::table('users')->where('id', $q -> autor)->first();
                    $autor = $autor -> imie.' '.$autor -> nazwisko;
                    $tytul = $q -> tytul;
                    $zdjecie = $q -> zdjecie;
                    $url = $q -> url;
                    $tresc = $q -> tresc;
                    $wstep = Blog::tylkoWstep($tresc);
                    if($return == ''){
                        $return = '
                        <div class="col-md-4 col-sm-6 col-lg-4 wpisBlog">
                            <div class="blg-bx">
                                <div class="blg-thmb" style="height: 250px; background:url('.$zdjecie.') no-repeat; background-size:cover;"></div>
                                <div class="blg-inf">
                                    <h6 itemprop="headline"><a href="/b/'.$url.'" title="'.$tytul.'" itemprop="url">'.$tytul.'</a></h6>
                                    <ul class="pst-mta">
                                        <li><i class="fas fa-user"></i><a href="/b/'.$tytul.'" title="" itemprop="url">'.$autor.'</a></li>
                                    </ul>
                                    <p itemprop="description">
                                        '.$wstep.'
                                    </p>
                                    <a href="/b/'.$url.'" title="" itemprop="url">Przeczytaj</a>
                                </div>
                            </div>
                        </div>
                        ';
                    }else{
                        $return = $return.'
                        <div class="col-md-4 col-sm-6 col-lg-4 wpisBlog">
                            <div class="blg-bx">
                                <div class="blg-thmb" style="height: 250px; background:url('.$zdjecie.') no-repeat; background-size:cover;"></div>
                                <div class="blg-inf">
                                    <h6 itemprop="headline"><a href="/b/'.$url.'" title="'.$tytul.'" itemprop="url">'.$tytul.'</a></h6>
                                    <ul class="pst-mta">
                                        <li><i class="fas fa-user"></i><a href="/b/'.$tytul.'" title="" itemprop="url">'.$autor.'</a></li>
                                    </ul>
                                    <p itemprop="description">
                                        '.$wstep.'
                                    </p>
                                    <a href="/b/'.$url.'" title="" itemprop="url">Przeczytaj</a>
                                </div>
                            </div>
                        </div>
                        ';
                    }                    
                }
                return [
                    'wynik' => $return,
                    'ileWszystkich' => $wszystkich
                ];
            }
            return [
                'status' => 'ok',
                'nowe' => $sql
            ];
        }else{
            return ['status' => 'Brak autoryzacji'];
        }
    }
    public function dokumenty(){
        return view('user.dokumenty', [
            'dokumenty' => DB::table('dokumenty')->orderByDesc('id')->get(),
            'tytul' => 'Dokumenty',
            'ikony' => Glowna::tablicaIkon()
        ]);
    }
    public function kontaktPOST(){
        $score = RecaptchaV3::verify(request()->get('g-recaptcha-response'), 'register');
        if($score > 0.7) {
        $imie = $_POST['imie'];
        $email = $_POST['email'];
        $telefon = $_POST['telefon'];
        $tresc = $_POST['tresc'];
        $html = '
            <html
                <head>
                    <title>Nowa wiadomość ze strony osp-swierzawa.pl</title>
                </head>
                <body style="width:100%; text-align:center;">
                    <div style="width:50%; margin-left:25%">
                        <img src="https://osp-swierzawa.pl/assets/images/logo.png alt="" style="margin:auto;"/>
                    </div>
                    <div style="width:50%; margin-left:25%; text-align:center;">
                        <b>Imie:</b> '.$imie.'<br />
                        <b>Adres e-mail:</b> '.$email.'<br />
                        <b>Telefon:</b> '.$telefon.'<br />
                        <b>Treść:</b><br /><br /> '.$tresc.'<br />
                    </div>
                </body>
            </html>
        ';
        $temat = 'Nowa wiadomość na OSP-swierzawa.pl';
        $do_kogo = '998waldek@wp.pl';
        Mailing::mail($do_kogo, $temat, $html);
        $do_kogo = 'mateusz@rataq.pl';
        Mailing::mail($do_kogo, $temat, $html);
        DB::table('wiadomosci')->insert([
            'id' => null,
            'imie' => $imie,
            'email' => $email,
            'telefon' => $telefon,
            'tresc' => $tresc,
            'kiedy' => date("Y-m-d H:i:s"),
            'ip' => request()->ip()
        ]);
        $komunikat = '
            <div class="col-md-12 alert alert-success">
                <h3 class="text-center">Dziękujemy za wiadomość.</h3>
                <p class="text-center">
                    Odpowiemy na wysłaną wiadomość, najszybciej jak będzie to tylko możliwe. W sprawach pilnych, zachęcamy do kontaktu telefonicznego.
                </p>
            </div>
        ';
    }else{
        $komunikat = '
            <div class="col-md-12 alert alert-success">
                <h3 class="text-center">Nie wysłaliśmy wiadomości.</h3>
                <p class="text-center">
                    W związku z brakiem autoryzacji, wiadomość została odrzucona.
                </p>
            </div>
        ';
    }
        return redirect('/kontakt')->with('komunikat', $komunikat);
    }
    public function kontakt(){
        return view('user.kontakt', [
            'tytul' => 'Kontakt z nami',
            'komunikat' => session('komunikat')
        ]);
    }
    public function jakoscPowietrza(){
        return view('user.podstrona', [
            'tytul' => 'Jakość powietrza w Świerzawie',
            'q' => DB::table('podstrony')->where('url', 'jakosc-powietrza')->first()
        ]);
    }
    public function podstrony(){
        $url = request()->segment(1);
        $q = DB::table('podstrony')->where('url', $url)->first();
        return view('user.podstrona', [
            'q' => $q,
            'tytul' => $q -> tytul
        ]);
    }
    public function statystyki(){
        // Statystyki - zwraca przykładowe dane
        // Można podłączyć zewnętrzne API lub bazę danych ospanel
        return [
            ['kategoria' => 'Pożary', 'iloscDzialan' => 15],
            ['kategoria' => 'Miejscowe zagrożenia', 'iloscDzialan' => 28],
            ['kategoria' => 'Alarmy fałszywe', 'iloscDzialan' => 3],
        ];
    }
    public function import(){
        $plik = file_get_contents('OSP-wpisy.xml');
        $wpisy = explode('<post>', $plik);
        for($i=1;$i<count($wpisy);$i++){
            $wpis = explode('</post>', $wpisy[$i]);
            $wpis = $wpis[0];
            $autorImie = explode('<AuthorFirstName>', $wpis);
            $autorImie = explode('</AuthorFirstName>', $autorImie[1]);
            $autorImie = $autorImie[0];
            
            $autorNazwisko = explode('<AuthorLastName>', $wpis);
            $autorNazwisko = explode('</AuthorLastName>', $autorNazwisko[1]);
            $autorNazwisko = $autorNazwisko[0];
            
            $autorNazwa = explode('<AuthorUsername>', $wpis);
            $autorNazwa = explode('</AuthorUsername>', $autorNazwa[1]);
            $autorNazwa = $autorNazwa[0];
            
            $autor = Glowna::kontoUsera($autorImie, $autorNazwisko, $autorNazwa);

            $tytul = explode('<Title>', $wpis);
            $tytul = explode('</Title>', $tytul[1]);
            $tytul = $tytul[0];

            $url = explode('<Permalink>', $wpis);
                $url = explode('</Permalink>', $url[1]);
                $url = $url[0];
                $url = explode('/', $url);
                $elementURL = count($url);
                $elementURL = $elementURL - 1;
                if($url[$elementURL] == ''){
                    $elementURL = $elementURL - 1;
                }
                $url = $url[$elementURL];
            $tresc = explode('<Content>', $wpis);
            $tresc = explode('</Content>', $tresc[1]);
            $tresc = $tresc[0];
            $tresc = str_replace('<![CDATA[', '', $tresc);
            $tresc = str_replace(']]>', '', $tresc);

            $poprzedni_url = '';
            
            $zdjecia = explode('<ImageURL>', $wpis);
            $zdjecia = explode('</ImageURL>', $zdjecia[1]);
            $zdjecia = $zdjecia[0];

            $zdjecia = Glowna::pobierzZdjecia($zdjecia);
            if(isset($zdjecia[0]) && $zdjecia[0] != ''){
                $zdjecie = $zdjecia[0];
            }else{
                $zdjecie = '/upload/brak.png';
            }
            
            $kategoria = explode('<Kategorie>', $wpis);
            $kategoria = explode('</Kategorie>', $kategoria[1]);
            $kategoria = $kategoria[0];
            $kategoria = str_replace('<![CDATA', '', $kategoria);
            $kategoria = str_replace(']]>', '', $kategoria);
            $kategoria = explode('>', $kategoria);
            $kategoria = $kategoria[0];
            
            $zalaczniki = explode('<AttachmentURL>', $wpis);
            $zalaczniki = explode('</AttachmentURL>', $zalaczniki[1]);
            $zalaczniki = $zalaczniki[0];
            $zalaczniki = Glowna::doZalacznikow($zalaczniki);

            DB::table('aktualnosci')->insert([
                'id' => null,
                'tytul' => $tytul,
                'url' => $url,
                'poprzedni_url' => $poprzedni_url,
                'tresc' => $tresc,
                'zdjecie' => $zdjecie,
                'kategoria' => $kategoria,
                'autor' => $autor,
                'zalaczniki' => $zalaczniki
            ]);

            $sql = DB::table('aktualnosci')->orderByDesc('id')->first();
            for($g=1;$g<count($zdjecia);$g++){
                Glowna::doGalerii($zdjecia[$g], $tytul, $sql -> id);
            }
            
            
            echo $tresc;

        }
    }
    public function doZalacznikow($zalaczniki){
        $zalaczniki = explode('|', $zalaczniki);
        $lista = '';
        for($h=0;$h<count($zalaczniki);$h++){
            $zalacznik = $zalaczniki[$h];
            if($zalacznik != ''){
            $zapisz = explode('/', $zalacznik);
                $elementZalacznik = count($zapisz);
                $elementZalacznik = $elementZalacznik - 1;
            $zapisz = $zapisz[$elementZalacznik];
            $zapisz = 'upload/zalaczniki/'.$zapisz;
            if(!copy($zalacznik, $zapisz)){
            }else{
                if($lista == ''){
                    $lista = '/'.$zapisz;
                }else{
                    $lista = $lista.',/'.$zapisz;
                }
            }
        }
        }
        return $lista;
    }
    public function doGalerii($fota, $tytul, $id){
        DB::table('aktualnosci_zdjecia')->insert([
            'id' => null,
            'aktualnosci_id' => $id,
            'zdjecie' => $fota,
            'alt' => $tytul
        ]);
    }
    public function pobierzZdjecia($zdjecia){
        $zdjecia = explode('|', $zdjecia);
        $lista = [];
        for($j=0;$j<count($zdjecia);$j++){
            $fota = $zdjecia[$j];
            if($fota != '' && strpos($fota, " ") == false){
            $zapisz = explode('/', $fota);
                $elementFota = count($zapisz);
                $elementFota = $elementFota - 1;
            $zapisz = $zapisz[$elementFota];
            $zapisz = 'upload/blog/'.$zapisz;
            echo $fota.'<br />'.$zapisz.'<br /><br />';
            if(!copy($fota, $zapisz)){
                return 'Problem z wgraniem zdjęć';
            }else{
                array_push($lista, '/'.$zapisz);
            }
        }
        }
        return $lista;
    }
    public function kontoUsera($imie, $nazwisko, $nazwa){
        $sql = DB::table('users')->where('imie', $imie)->where('nazwisko', $nazwisko)->get();
        if(count($sql) > 0){
            //juz jest
            return $sql[0] -> id;
        }else{
            $noweHaslo = $imie.$nazwisko;
            DB::table('users')->insert([
                'id' => null,
                'name' => $nazwa,
                'email' => $nazwa,
                'email_verified_at' => null,
                'password' => Hash::make($noweHaslo),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'imie' => $imie,
                'nazwisko' => $nazwisko
            ]);
            $sql = DB::table('users')->orderByDesc('id')->first();
            return $sql -> id;
        }
    }
    public function generuj(){
        return view('user/glowna', [
            'tytul' => Api::tytulStrony(),
            'slider' => DB::table('aktualnosci')->orderByDesc('id')->limit(4)->get(),
            'kampanie' => DB::table('aktualnosci')->where('kategoria', 'Kampanie')->orderByDesc('id')->limit(5)->get(),
            'filmy' => DB::table('video')->inRandomOrder()->limit(10)->get(),
            'zdarzenia' => DB::table('aktualnosci')->where('kategoria', 'LIKE', '%zdarzenia%')->orderByDesc('id')->limit(2)->get(),
            'inne' => DB::table('aktualnosci')->where('kategoria', '!=', 'ZDARZENIA')->orderByDesc('id')->limit(3)->get(),
            'statystyki' => Glowna::statystyki(),
            'testy' => DB::table('testy')->orderByDesc('id')->limit(3)->get(),
        ]);
    }

    public function sitemap()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1));
        $sitemap->add(Url::create('/dokumenty')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        $sitemap->add(Url::create('/kontakt')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        $sitemap->add(Url::create('/dzialania-ratownicze')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        $sitemap->add(Url::create('/MDP')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        $sitemap->add(Url::create('/kampanie')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        foreach(\DB::table('aktualnosci')->orderByDesc('id')->get() as $news){
            $sitemap->add(Url::create('/b/'.$news->url)
                    ->setLastModificationDate(now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.6));
        }
        $sitemap->writeToFile(public_path('sitemap.xml'));
        $xml = file_get_contents(public_path('sitemap.xml'));

        return $xml;
    }
}
