<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Admin extends Controller
{
    public function sponsorzyEdycja($id){
        return view('admin.sponsorzyEdycja', [
            'sponsor' => DB::table('sponsorzy')->where('id', $id)->first()
        ]);
    }

    public function sponsorzyEdycjaPOST($id){
        $sponsor = DB::table('sponsorzy')->where('id', $id)->first();
        if(request()->file('zdjecie') !== null){
            $zdjecie = $_FILES['zdjecie'];
            $fname = $zdjecie['name'];
            //echo $fname.'<br />';
            $ftmp = $zdjecie['tmp_name'];
            $rozszerzenie = explode('.', $fname);
            $nowe = 'upload/wgrane/'.md5(date("YmdHis")).'.'.$rozszerzenie[1];
            if(!copy($ftmp, $nowe)){
                $komunikat = '
                        <div class="col-md-12 alert alert-warning">
                            <h3 class="text-center">Wystąpił problem z zapisem grafiki!</h3>
                        </div>
                ';
                return back()->with('komunikat', $komunikat);
            }else{
                //echo $fname.' wgrano poprawnie.<br />';
                $fota = '/'.$nowe;
            }
        }
        if(!isset($fota)){
            $fota = $sponsor->zdjecie;
        }
        DB::table('sponsorzy')->where('id', $id)->update([
            'nazwa' => request()->get('nazwa'),
            'zdjecie' => $fota,
            'opis' => request()->get('opis'),
            'www' => request()->get('www'),
            'facebook' => request()->get('facebook'),
            'instagram' => request()->get('instagram'),
            'tiktok' => request()->get('tiktok'),
            'twitter' => request()->get('twitter'),
            'youtube' => request()->get('youtube'),
            'updated_at' => now()
        ]);
        $komunikat = '
                        <div class="col-md-12 alert alert-success">
                            <h3 class="text-center">Zmiany zapisano prawidłowo!</h3>
                        </div>
        ';
        return redirect(url('/admin/sponsorzy'))->with('komunikat', $komunikat);
    }

    public function sponsorzyUsun($id){
        DB::table('sponsorzy')->where('id', $id)->delete();
        $komunikat = '
                        <div class="col-md-12 alert alert-danger">
                            <h3 class="text-center">Usunięto sponsora!</h3>
                        </div>
            ';
            return redirect('/admin/sponsorzy')->with('komunikat', $komunikat);
    }
    public function sposorzyDodajPOST(Request $request){
        if($request->file('zdjecie') == null){
            $komunikat = '
                        <div class="col-md-12 alert alert-warning">
                            <h3 class="text-center">Nie wybrano zdjęcia!</h3>
                        </div>
            ';
            return back()->with('komunikat', $komunikat);
        }
        if($request->get('nazwa') == null){
            $komunikat = '
                        <div class="col-md-12 alert alert-warning">
                            <h3 class="text-center">Nie podano nazwy!</h3>
                        </div>
            ';
            return back()->with('komunikat', $komunikat);
        }
        $zdjecie = $_FILES['zdjecie'];
        $fname = $zdjecie['name'];
            //echo $fname.'<br />';
            $ftmp = $zdjecie['tmp_name'];
            $rozszerzenie = explode('.', $fname);
            $nowe = 'upload/wgrane/'.md5(date("YmdHis")).'.'.$rozszerzenie[1];
            if(!copy($ftmp, $nowe)){
                $komunikat = '
                        <div class="col-md-12 alert alert-warning">
                            <h3 class="text-center">Wystąpił problem z zapisem grafiki!</h3>
                        </div>
                ';
                return back()->with('komunikat', $komunikat);
            }else{
                //echo $fname.' wgrano poprawnie.<br />';
                $fota = '/'.$nowe;
            }
        DB::table('sponsorzy')->insert([
            'nazwa' => $request->get('nazwa'),
            'zdjecie' => $fota,
            'opis' => $request->get('opis'),
            'www' => $request->get('www'),
            'facebook' => $request->get('facebook'),
            'instagram' => $request->get('instagram'),
            'tiktok' => $request->get('tiktok'),
            'twitter' => $request->get('twitter'),
            'youtube' => $request->get('youtube'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $komunikat = '
                        <div class="col-md-12 alert alert-success">
                            <h3 class="text-center">Dodano nowego sponsora!</h3>
                        </div>
        ';
        return redirect(url('/admin/sponsorzy'))->with('komunikat', $komunikat);
    }

    public function sposorzyDodaj(){
        return view('admin.sponsorzyDodaj', [
            'komunikat' => session('komunikat')
        ]);
    }

    public function sponsorzy(){
        return view('admin.sponsorzy', [
            'sponsorzy' => DB::table('sponsorzy')->orderByDesc('id')->get(),
            'komunikat' => session('komunikat'),
        ]);
    }
    public function usunWideoPotwierdzPOST($id){
        $sql = DB::table('aktualnosciWideo')->where('id', $id)->first();
        Storage::delete($sql -> url);
        $info = '
                        <div class="col-md-12 alert alert-warning">
                            <h3 class="text-center">Usunięto film z wpisu!</h3>
                        </div>
            ';
        DB::table('aktualnosciWideo')->where('id', $id)->delete();
        return redirect('admin/blog/video/'.$sql -> aktualnosciID)->with('info', $info);

    }
    public function usunWideoPotwierdz($id){
        return view('admin.potwierdzUsuwanie');
    }
    public function zarzadzajVideoWpisPOST($id){
        if(request()->file('video') != null){
            $video = request()->file('video')->store('vid');
            DB::table('aktualnosciWideo')->insert([
                'url' => $video,
                'aktualnosciID' => $id
            ]);
            $info = '
                        <div class="col-md-12 alert alert-success">
                            <h3 class="text-center">Dodano nowe wideo do wpisu!</h3>
                        </div>
            ';
        }else{
            $info = '
                        <div class="col-md-12 alert alert-danger">
                            <h3 class="text-center">Musisz wybrać plik wideo!</h3>
                        </div>
            ';
        }
        return redirect(url()->current())->with('info', $info);
    }
    public function zarzadzajVideoWpis($id){
        return view('admin.zarzadzajVideoWpis', [
            'info' => session('info'),
            'video' => DB::table('aktualnosciWideo')->where('aktualnosciID', $id)->get(),
            'wpis' => DB::table('aktualnosci')->where('id', $id)->first()
        ]);
    }
    public function galeriaWpisuUsunZdjecie($id){
        $sql = DB::table('aktualnosciGalerie')->where('id', $id)->first();
        $wrocID = $sql -> aktualnosciID;
        DB::table('aktualnosciGalerie')->where('id', $id)->delete();
        return redirect('/admin/galeria/'.$wrocID);
    }
    public function galeriaWpisuDodaj($id){
        $zdjecia = $_FILES['zdjecia'];
        $i = 0;
        foreach($_FILES['zdjecia']['tmp_name'] as $fota){
            $zdj = 'upload/wgrane/'.md5(date("Y-m-d-H-i-s").$i.'.jpg');
            if(!copy($fota, $zdj)){
                return 'Problem z wgraniem zdjęć.';
            }else{
                DB::table('aktualnosciGalerie')->insert([
                    'url' => '/'.$zdj,
                    'tytul' => null,
                    'aktualnosciID' => request()->segment(3)
                ]);
            }
            $i++;
        }
        return redirect(url()->current());
    }
    public function galeriaBlog($id){
        return view('admin.galeriaWpisu', [
            'komunikat' => session('komunikat'),
            'zdjecia' => DB::table('aktualnosciGalerie')->where('aktualnosciID', $id)->get(),
            'wpis' => DB::table('aktualnosci')->where('id', $id)->first()
        ]);
    }
    public function dokumentyUsunPOST(){
        DB::table('dokumenty')->where('id', request()->segment(4))->delete();
        $komunikat = '
                        <div class="col-md-12 alert alert-warning">
                            <h3 class="text-center">Usunięto dokumenty!</h3>
                        </div>
        ';
        return redirect('admin/dokumenty')->with('komunikat', $komunikat);
    }
    public function dokumentyUsun(){
        return view('admin.dokumentyUsun', [
            'komunikat' => session('komunikat')
        ]);
    }
    public function dokumentyDodajPOST(){
        $nazwa = $_POST['nazwa'];
        $opis = $_POST['opis'];
        $dokumenty = $_FILES['dokumenty'];
        if(count($dokumenty['name']) > 0){
            $lista_dokumentow = '';
            for($i=0;$i<count($dokumenty['name']);$i++){
                $dokument = 'upload/dokumenty/'.date("YmdHis").'-'.$dokumenty['name'][$i];
                if(!copy($dokumenty['tmp_name'][$i], $dokument)){
                    $komunikat = '
                        <div class="col-md-12 alert alert-danger">
                            <h3 class="text-center">Nie udało się wgrać przynajmniej jednego z plików!</h3>
                        </div>
                    ';
                    return redirect(url() -> current())->with('komunikat', $komunikat);
                }else{
                    $dokument = '/'.$dokument;
                    if($lista_dokumentow == ''){
                        $lista_dokumentow = $dokument;
                    }else{
                        $lista_dokumentow = $lista_dokumentow.','.$dokument;
                    }
                }
            }
            DB::table('dokumenty')->insert([
                'id' => null,
                'nazwa' => $nazwa,
                'opis' => $opis,
                'dokumenty' => $lista_dokumentow
            ]);
            $komunikat = '
                <div class="col-md-12 alert alert-success">
                    <h3 class="text-center">Dokumenty dodane, są już widoczne na stronie!</h3>
                </div>
            ';
            return redirect('admin/dokumenty')->with('komunikat', $komunikat);
        }else{
            $komunikat = '
                <div class="col-md-12 alert alert-danger">
                    <h3 class="text-center">Musisz wybrać przynajmniej jeden z plików!</h3>
                </div>
            ';
            return redirect(url() -> current())->with('komunikat', $komunikat);
        }
    }
    public function dokumentyDodaj(){
        return view('admin.dokumentyDodaj', [
            'komunikat' => session('komunikat')
        ]);
    }
    public function dokumentyGlowna(){
        return view('admin.dokumenty', [
            'dokumenty' => DB::table('dokumenty')->orderByDesc('id')->get(),
            'komunikat' => session('komunikat'),
            'ikony' => Glowna::tablicaIkon()
        ]);
    } 
    public function podstronyPOST($url){
        $tytul = $_POST['tytul'];
        $zdjecie = $_FILES['zdjecie'];
        $tresc = Admin::jesli_w_tresci_jest_img_base64($_POST['tresc']);
        if($zdjecie['name'] != ''){
            $fota = 'upload/wgrane/'.md5(date("YmdHis")).'.jpg';
            if(!copy($zdjecie['tmp_name'], $fota)){
                $zdjecie = $_POST['zdjecieTeraz'];
            }else{
                $zdjecie = '/'.$fota;
            }
        }else{
            $zdjecie = $_POST['zdjecieTeraz'];
        }
        DB::table('podstrony')->where('url', $url)->update([
            'tytul' => $tytul,
            'tresc' => $tresc,
            'zdjecie' => $zdjecie
        ]);
        $komunikat = '
            <div class="col-md-12 alert alert-success">
                <h3 class="text-center">Poprawnie zapisano zmiany we wpisie!</h3>
            </div>
        ';
        return redirect(url() -> current())->with('komunikat', $komunikat);
    }
    public function podstrony($url){
        return view('admin/podstrona', [
            'q' => DB::table('podstrony')->where('url', $url)->first(),
            'komunikat' => session('komunikat')
        ]);
    }
    public function blogUsunPOST(){
        DB::table('aktualnosci')->where('id', request()->segment(4))->delete();
        $komunikat = '
            <div class="col-md-12 alert alert-warning">
                <h3 class="text-center">Wpis usunięto prawidłowo!</h3>
            </div>
        ';
        return redirect('/admin/blog')->with('komunikat', $komunikat);
    }
    public function blogUsun(){
        return view('admin.blogUsun', [
            
        ]);
    }
    public function blogEdytujPOST(){
        $tytul = $_POST['tytul'];
        $kategoria = $_POST['kategoria'];
        $url = $_POST['url'];
        $tresc = Admin::jesli_w_tresci_jest_img_base64($_POST['tresc']);
        $zdjecie = $_FILES['zdjecie'];
        if($zdjecie['name'] != ''){
            $nowe = 'upload/wgrane/'.md5(date("YmdHis")).'.jpg';
            if(!copy($zdjecie['tmp_name'], $nowe)){
                $zdjecie = $_POST['zdjecieTeraz'];
            }else{
                $zdjecie = '/'.$nowe;
            }
        }else{
            $zdjecie = $_POST['zdjecieTeraz'];
        }
        DB::table('aktualnosci')->where('id', request()->segment(4))->update([
            'tytul' => $tytul,
            'kategoria' => $kategoria,
            'url' => $url,
            'tresc' => $tresc,
            'zdjecie' => $zdjecie
        ]);
            $komunikat = '
                <div class="col-md-12 alert alert-success">
                    <h3 class="text-center">Zmiany wprowdzone zostały poprawnie</h3>
                </div>
            ';
            return redirect(url()->current())->with('komunikat', $komunikat);
    }
    public function blogEdytuj(){
        return view('admin.blogEdytuj', [
            'q' => DB::table('aktualnosci')->where('id', request()->segment(4))->first(),
            'komunikat' => session('komunikat')
        ]);
    }
    public function blogDodajPOST(){
        $tytul = $_POST['tytul'];
        $kategoria = $_POST['kategoria'];
        $url = $_POST['url'];
        $tresc = Admin::jesli_w_tresci_jest_img_base64($_POST['tresc']);
        $zdjecia = $_FILES['zdjecia'];
        $lista_zdjec = '';
        for($i=0;$i<count($zdjecia['name']);$i++){
            $fname = $zdjecia['name'][$i];
            //echo $fname.'<br />';
            $ftmp = $zdjecia['tmp_name'][$i];
            $rozszerzenie = explode('.', $fname);
            $nowe = 'upload/wgrane/'.md5(date("YmdHis").$i).'.'.$rozszerzenie[1];
            if(!copy($ftmp, $nowe)){
                //echo $fname.' nie może zostać skopiowane';
            }else{
                //echo $fname.' wgrano poprawnie.<br />';
                $fota = '/'.$nowe.',';
                echo $fota.'<br />';
                $lista_zdjec = $lista_zdjec.$fota;
            }
        }
        echo $lista_zdjec.'<br />';
        $lista_zdjec = explode(',', $lista_zdjec);
        if(isset($lista_zdjec[0]) && $lista_zdjec[0] != ''){
            DB::table('aktualnosci')->insert([
                'id' => null,
                'tytul' => $tytul,
                'url' => $url,
                'poprzedni_url' => '',
                'tresc' => $tresc,
                'zdjecie' => $lista_zdjec[0],
                'kategoria' => $kategoria,
                'autor' => request()->user()->id,
                'zalaczniki' => ''
            ]);
            $sql = DB::table('aktualnosci')->orderByDesc('id')->first();
            for($i=1;$i<count($lista_zdjec);$i++){
                if($lista_zdjec[$i] != ''){
                    DB::table('aktualnosci_zdjecia')->insert([
                        'id' => null,
                        'aktualnosci_id' => $sql -> id,
                        'zdjecie' => $lista_zdjec[$i],
                        'alt' => $tytul
                    ]);
                }
            }
            $komunikat = '
                <div class="col-md-12 alert alert-success">
                    <h3 class="text-center">Dodano</h3>
                </div>
            ';
        }else{
            $komunikat = '
                <div class="col-md-12 alert alert-danger">
                    <h3 class="text-center">Musisz dodać przynajmniej jedno zdjęcie</h3>
                </div>
            ';
        }
        return redirect('/admin/blog')->with('komunikat', $komunikat);
    }
    public function blogDodaj(){
        return view('user.blogDodaj', [
            'komunikat' => session('komunikat')
            
        ]);
    }
    public function blog(){
        return view('admin.blog', [
            'wpisy' => DB::table('aktualnosci')->orderByDesc('id')->limit(50)->get(),
            'komunikat' => session('komunikat')
        ]);
    }
    public function kursyPytaniaUsunPOST(){
        $sql = DB::table('testy_pytania')->where('id', request()->segment(5))->first();
        DB::table('testy_pytania')->where('id', request()->segment(5))->delete();
        $komunikat = Admin::komunikat('warning', 'Usunięto!', 'Pytanie zostało usunięte z bazy danych.');
        return redirect('/admin/kursy/pytania/'.$sql -> testy_id)->with('komunikat', $komunikat);
    }
    public function kursyPytaniaUsun(){
        return view('admin.kursyPytaniaUsun', [

        ]);
    }
    public function kursyPytaniaDodajPOST(){
        $pytanie = $_POST['tytul'];
        $odpowiedzi = $_POST['odpowiedzi'];
        $wlasciwa = $_POST['wlasciwa'];
        $wyjasnienie = $_POST['wyjasnienie'];
        DB::table('testy_pytania')->insert([
            'id' => null,
            'testy_id' => request()->segment(5),
            'pytanie' => $pytanie, 
            'wyjasnienie' => $wyjasnienie,
            'odpowiedzi' => $odpowiedzi,
            'prawidlowa' => $wlasciwa
        ]);
        $komunikat = Admin::komunikat('success', 'Dodano!', 'Pytanie prawidłowo dodano do wskazanego testu. Możesz dodawać kolejne, lub przejść do <a href="/admin/kursy/pytania/'.request()->segment(5).'" class="btn btn-dark">LISTY PYTAŃ</a>');
        return redirect(url()->current())->with('komunikat', $komunikat);
    }
    public function kursyPytaniaDodaj(){
        return view('admin/kursyPytaniaDodaj', [
            'komunikat' => session('komunikat')
        ]);
    }
    public function kursyPytania($id){
        return view('admin.kursyPytania', [
            'pytania' => DB::table('testy_pytania')->where('testy_id', $id)->get(),
            'komunikat' => session('komunikat')
        ]);
    }
    public function kursyUsunPOST($id){
        DB::table('testy')->where('id', request()->segment(4))->delete();
        $komunikat = Admin::komunikat('warning', 'Usunięto!', 'Kurs został usunięty i nie jest już widoczny w bazie danych.');
        return redirect('/admin/kursy')->with('komunikat', $komunikat);
    }
    public function kursyUsun($id){
        return view('admin.kursyUsun', [
            'idUsun' => $id
        ]);
    }
    public function kursyDodajPOST(){
        $tytul = $_POST['tytul'];
        $url = $_POST['url'];
        $opis = $_POST['opis'];
        $zdjecie = $_FILES['zdjecie'];
        if($zdjecie['name'] != ''){
            $fota = 'upload/kursy/'.md5(date("YmdHis")).'.jpg';
            if(!copy($zdjecie['tmp_name'], $fota)){
                $komunikat = Admin::komunikat('danger', 'Problem ze zdjęciem!', 'Prawdopodobnie wybrałeś/aś nieprawidłowy format pliku.');
                return redirect(url()->current())->with('komunikat', $komunikat);
            }else{
                $fota = '/'.$fota;
                DB::table('testy')->insert([
                    'id' => null,  
                    'tytul' => $tytul,
                    'url' => $url,
                    'opis' => $opis,
                    'zdjecie' => $fota
                ]);
                $komunikat = Admin::komunikat('success', 'Udało się!', 'Prawidłowo utworzono kurs o nazwie <strong>'.$tytul.'</strong>. Koniecznie dodaj do niego teraz pytania!');
                return redirect('/admin/kursy')->with('komunikat', $komunikat);
            }
        }else{
            $komunikat = Admin::komunikat('danger', 'Brak zdjęcia!', 'Dodając kurs, musisz wybrać zdjęcie jako miniaturę testu.');
            return redirect(url()->current())->with('komunikat', $komunikat);
        }
    }
    public function kursyDodaj(){
        return view('admin.kursyDodaj', [
            'komunikat' => session('komunikat')
        ]);
    }
    public function kursy(){
        return view('admin.kursy', [
            'kursy' => DB::table('testy')->orderByDesc('id')->get(),
            'komunikat' => session('komunikat')
        ]);
    }
    public function zmianaHaslaAdminaPOST(){
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
        if($haslo1 == $haslo2){
            $usersID = request()->user()->id;
            DB::table('users')->where('id', $usersID)->update([
                'password' => Hash::make($haslo1)
            ]);

            $komunikat = Admin::komunikat('warning', 'Hasło zostało zmienione!', 'Prawidłowo wprowadzono zmiany w haśle dla Twojego konta. Zaloguj się ponownie, za pomocą nowego hasła.');
            Auth::logout();
            return redirect(route('login'))->with('komunikat', $komunikat);
        }else{
            $komunikat = Admin::komunikat('danger', 'Hasła nie mogą się różnić!', null);
            return redirect(url()->current())->with('komunikat', $komunikat);
        }
    }
    public function zmianaHaslaAdmina(){
        return view('admin.zmianaHasla', [
            'q' => DB::table('users')->where('id', request()->user()->id)->first(),
            'komunikat' => session('komunikat')
        ]);
    }
    public function wyloguj(){
        Auth::logout();
        $komunikat = Admin::komunikat('dark', 'Wylogowano!', null);
        return redirect(route('login'))->with('komunikat', $komunikat);
    }
    public function glowna(){
        return view('admin/glowna', [

        ]);
    }
    public function logowaniePOST(){
        if (Auth::attempt(['name' => $_POST['login'], 'password' => $_POST['haslo'], 'admin' => 1])) {
            return redirect(route('admin'));
        }else{
            $komunikat = Admin::komunikat('danger', 'Niepoprawne dane', null);
            return redirect(route('login'))->with('komunikat', $komunikat);
        }
    }
    public function logowanie(){
        return view('admin/logowanie', [
            'komunikat' => session('komunikat')
        ]);
    }
    public function komunikat($class, $tytul, $tresc){
        return '
            <div class="col-md-12 alert alert-'.$class.'">
                <h3 class="text-center">
                    '.$tytul.'
                </h3>
                <p class="text-center">
                    '.$tresc.'
                </p>
            </div>
        ';
    }
    public function jesli_w_tresci_jest_img_base64(&$tresc){
        $czy = strpos($tresc, 'src="data:image');
        if ($czy == FALSE){
            $tresc = $tresc;
        }else{ 
            $foty = explode('src="data:image', $tresc);
            $ile = count($foty);
            $i = 1;
            while($ile > $i){
                $fota = explode('"', $foty[$i]);
                $fota = 'data:image'.$fota[0];
                $zdj = Admin::generateImage($fota);
                $tresc = str_replace($fota, $zdj, $tresc);
                $i++;
            }
        }
        $caly_img = explode('<img', $tresc);
        $ile = count($caly_img);
        $i = 1;
        while($ile > $i){
            $odnosnik = explode('>', $caly_img[$i]);
            $odnosnik = '<'.$odnosnik[0].'>';
            $src = explode('src="', $odnosnik);
            $src = explode('"', $src[1]);
            $src = $src[0];
            $webp = str_replace('.jpg', '.webp', $src);
            $nowa = '
                <picture>
                    <source srcset="'.$webp.'" type="image/webp">
                    <source srcset="'.$src.'" type="image/jpeg"> 
                    '.$odnosnik.'
                </picture>
            ';
            $tresc = str_replace($odnosnik, $nowa, $tresc);
            $i++;
        }
        return $tresc;
}
public function generateImage($img){
    $folderPath = "upload/wgrane/";



    $image_parts = explode(";base64,", $img);

    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];

    $image_base64 = base64_decode($image_parts[1]);

    $file = $folderPath . uniqid() . '.jpg';


    file_put_contents($file, $image_base64);
    $webp = str_replace('.jpg', '.webp', $file);
    file_put_contents($webp, $image_base64);
    $file = '/'.$file;
    return ($file);
}

    // ========== ADMIN MANAGEMENT ==========

    public function administratorzy()
    {
        $user = request()->user();
        if ($user->role !== 'super_admin') {
            return redirect('/admin')->with('komunikat', Admin::komunikat('danger', 'Brak uprawnien!', 'Tylko Super Administrator ma dostep do tej sekcji.'));
        }

        return view('admin.administratorzy', [
            'administratorzy' => DB::table('users')->where('admin', 1)->orderByDesc('id')->get(),
            'komunikat' => session('komunikat')
        ]);
    }

    public function administratorzyDodaj()
    {
        $user = request()->user();
        if ($user->role !== 'super_admin') {
            return redirect('/admin')->with('komunikat', Admin::komunikat('danger', 'Brak uprawnien!', null));
        }

        return view('admin.administratorzyDodaj', [
            'komunikat' => session('komunikat')
        ]);
    }

    public function administratorzyDodajPOST(Request $request)
    {
        $user = request()->user();
        if ($user->role !== 'super_admin') {
            return redirect('/admin');
        }

        // Validation
        if (empty($request->get('name')) || empty($request->get('email')) || empty($request->get('password'))) {
            $komunikat = Admin::komunikat('danger', 'Blad!', 'Wszystkie pola sa wymagane.');
            return back()->with('komunikat', $komunikat);
        }

        // Check if email exists
        $exists = DB::table('users')->where('email', $request->get('email'))->first();
        if ($exists) {
            $komunikat = Admin::komunikat('danger', 'Blad!', 'Podany adres e-mail juz istnieje w bazie.');
            return back()->with('komunikat', $komunikat);
        }

        DB::table('users')->insert([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'imie' => $request->get('imie'),
            'nazwisko' => $request->get('nazwisko'),
            'admin' => 1,
            'role' => $request->get('role', 'admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $komunikat = Admin::komunikat('success', 'Dodano!', 'Nowy administrator zostal dodany do systemu.');
        return redirect('/admin/administratorzy')->with('komunikat', $komunikat);
    }

    public function administratorzyUsun($id)
    {
        $user = request()->user();
        if ($user->role !== 'super_admin') {
            return redirect('/admin');
        }

        $admin = DB::table('users')->where('id', $id)->first();

        // Protect super_admin and main accounts
        if ($admin->role === 'super_admin' || $admin->email === 'mateusz@rataq.pl' || strtolower($admin->name) === 'rataq' || strtolower($admin->name) === 'mateusz') {
            $komunikat = Admin::komunikat('danger', 'Blad!', 'Nie mozna usunac konta Super Administratora.');
            return redirect('/admin/administratorzy')->with('komunikat', $komunikat);
        }

        if ($admin->id == $user->id) {
            $komunikat = Admin::komunikat('danger', 'Blad!', 'Nie mozesz usunac wlasnego konta.');
            return redirect('/admin/administratorzy')->with('komunikat', $komunikat);
        }

        // Delete tokens first
        DB::table('personal_access_tokens')
            ->where('tokenable_type', 'App\\Models\\User')
            ->where('tokenable_id', $id)
            ->delete();

        DB::table('users')->where('id', $id)->delete();

        $komunikat = Admin::komunikat('warning', 'Usunieto!', 'Administrator zostal usuniety z systemu.');
        return redirect('/admin/administratorzy')->with('komunikat', $komunikat);
    }

    // ========== PROFILE & API TOKENS ==========

    public function profile()
    {
        $user = request()->user();
        $tokens = DB::table('personal_access_tokens')
            ->where('tokenable_type', 'App\\Models\\User')
            ->where('tokenable_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.profile', [
            'user' => $user,
            'tokens' => $tokens,
            'komunikat' => session('komunikat'),
            'newToken' => session('newToken')
        ]);
    }

    public function profileGenerateToken(Request $request)
    {
        $user = request()->user();
        $name = $request->get('token_name', 'API Token');
        $abilities = $request->get('abilities', []);

        if (empty($abilities)) {
            $komunikat = Admin::komunikat('danger', 'Blad!', 'Musisz wybrac przynajmniej jedno uprawnienie.');
            return back()->with('komunikat', $komunikat);
        }

        // Generate token using Sanctum
        $userModel = \App\Models\User::find($user->id);
        $token = $userModel->createToken($name, $abilities);
        $plainTextToken = $token->plainTextToken;

        $komunikat = Admin::komunikat('success', 'Token utworzony!', 'Skopiuj token ponizej. Nie bedzie mozna go ponownie wyswietlic.');
        return back()->with('komunikat', $komunikat)->with('newToken', $plainTextToken);
    }

    public function profileRevokeToken($tokenId)
    {
        $user = request()->user();

        DB::table('personal_access_tokens')
            ->where('id', $tokenId)
            ->where('tokenable_type', 'App\\Models\\User')
            ->where('tokenable_id', $user->id)
            ->delete();

        $komunikat = Admin::komunikat('warning', 'Usunieto!', 'Token API zostal uniewaziony.');
        return back()->with('komunikat', $komunikat);
    }
}
