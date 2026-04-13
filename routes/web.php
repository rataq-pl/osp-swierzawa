<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin;
use App\Http\Controllers\Glowna;
use App\Http\Controllers\Blog;
use App\Http\Controllers\Kontakt;
use App\Http\Controllers\Konkursy;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Glowna::class, 'generuj'])->name('glowna');
Route::get('/sitemap', [Glowna::class, 'sitemap']);
Route::get('/import', [Glowna::class, 'import']);
Route::get('/statystyki', [Glowna::class, 'statystyki']);
Route::get('b', [Blog::class, 'blogWpisy']);
Route::get('b/{url}', [Blog::class, 'blogWpisPokaz']);
Route::get('konkurs/{url}', [Konkursy::class, 'konkursyPokaz']);
Route::get('konkurs', [Konkursy::class, 'konkursyGlowna']);
Route::get('historia', [Glowna::class, 'podstrony']);
Route::get('zarzad', [Glowna::class, 'podstrony']);
Route::get('wyposazenie', [Glowna::class, 'podstrony']);
Route::get('zarzad', [Glowna::class, 'podstrony']);
Route::get('statut', [Glowna::class, 'podstrony']);
Route::get('wsparcie', [Glowna::class, 'podstrony']);
Route::get('zbiorka-elektro-smieci-osp-swierzawa', [Glowna::class, 'podstrony']);
Route::get('kampanie', [Blog::class, 'kampanie']);
Route::get('MDP', [Blog::class, 'mdp']);
Route::get('dzialania-ratownicze', [Blog::class, 'dzialaniaRatownicze']);
Route::get('jakosc-powietrza', [Glowna::class, 'jakoscPowietrza']);
Route::get('kontakt', [Glowna::class, 'kontakt']);
Route::post('kontakt', [Glowna::class, 'kontaktPOST']);
Route::get('dokumenty', [Glowna::class, 'dokumenty']);
Route::get('polityka-prywatnosci', [Glowna::class, 'politykaPrywatnosci']);
Route::post('pobierzPytania', [Konkursy::class, 'pobierzPytania']);
Route::post('startPytan', [Konkursy::class, 'startPytan']);
Route::post('aktualizujOdpowiedzi', [Konkursy::class, 'aktualizujOdpowiedzi']);
Route::post('oznaczGotowy', [Konkursy::class, 'oznaczGotowy']);
Route::post('wyslijWyniki', [Konkursy::class, 'wyslijWyniki']);
Route::post('pobierzStarsze', [Glowna::class, 'pobierzStarsze']);
Route::get('wysylkaWynikow', [Glowna::class, 'wysylkaWynikow']);

Route::get('/osp-admin125', [Admin::class, 'logowanie'])->name('login');
Route::post('/osp-admin125', [Admin::class, 'logowaniePOST']);

Route::middleware(['auth'])->group(function(){
    Route::get('/admin', [Admin::class, 'glowna'])->name('admin');
    Route::get('/admin/wyloguj', [Admin::class, 'wyloguj']);
    Route::get('admin/zmien-haslo', [Admin::class, 'zmianaHaslaAdmina']);
    Route::post('admin/zmien-haslo', [Admin::class, 'zmianaHaslaAdminaPOST']);
    Route::get('admin/kursy', [Admin::class, 'kursy'])->name('kursy');
    Route::get('admin/kursy/dodaj', [Admin::class, 'kursyDodaj']);
    Route::post('admin/kursy/dodaj', [Admin::class, 'kursyDodajPOST']);
    Route::get('admin/kursy/usun/{id}', [Admin::class, 'kursyUsun']);
    Route::post('admin/kursy/usun/{id}', [Admin::class, 'kursyUsunPOST']);
    Route::get('admin/kursy/pytania/{id}', [Admin::class, 'kursyPytania'])->name('kursyPytania');
    Route::get('admin/kursy/pytania/dodaj/{id}', [Admin::class, 'kursyPytaniaDodaj']);
    Route::post('admin/kursy/pytania/dodaj/{id}', [Admin::class, 'kursyPytaniaDodajPOST']);
    Route::get('admin/kursy/pytania/usun/{id}', [Admin::class, 'kursyPytaniaUsun']);
    Route::post('admin/kursy/pytania/usun/{id}', [Admin::class, 'kursyPytaniaUsunPOST']);
    Route::get('admin/blog', [Admin::class, 'blog'])->name('blog');
    Route::get('admin/blog/edytuj/{id}', [Admin::class, 'blogEdytuj']);
    Route::post('admin/blog/edytuj/{id}', [Admin::class, 'blogEdytujPOST']);
    Route::get('admin/blog/usun/{id}', [Admin::class, 'blogUsun']);
    Route::post('admin/blog/usun/{id}', [Admin::class, 'blogUsunPOST']);
    Route::get('admin/blog/dodaj', [Admin::class, 'blogDodaj']);
    Route::post('admin/blog/dodaj', [Admin::class, 'blogDodajPOST']);
    Route::get('/admin/podstrona/{url}', [Admin::class, 'podstrony']);
    Route::post('/admin/podstrona/{url}', [Admin::class, 'podstronyPOST']);
    Route::get('admin/dokumenty', [Admin::class, 'dokumentyGlowna']);
    Route::get('admin/dokumenty/dodaj', [Admin::class, 'dokumentyDodaj']);
    Route::post('admin/dokumenty/dodaj', [Admin::class, 'dokumentyDodajPOST']);
    Route::get('admin/dokumenty/edytuj/{id}', [Admin::class, 'dokumentyEdytuj']);
    Route::post('admin/dokumenty/edytuj/{id}', [Admin::class, 'dokumentyEdytujPOST']);
    Route::get('admin/dokumenty/usun/{id}', [Admin::class, 'dokumentyUsun']);
    Route::post('admin/dokumenty/usun/{id}', [Admin::class, 'dokumentyUsunPOST']);
    Route::get('admin/galeria/{id}', [Admin::class, 'galeriaBlog']);
    Route::post('admin/galeria/{id}', [Admin::class, 'galeriaWpisuDodaj']);
    Route::get('admin/galeria/usunFote/{id}', [Admin::class, 'galeriaWpisuUsunZdjecie']);
    Route::get('admin/blog/video/{id}', [Admin::class, 'zarzadzajVideoWpis']);
    Route::post('admin/blog/video/{id}', [Admin::class, 'zarzadzajVideoWpisPOST']);
    Route::get('admin/usunVideo/{id}', [Admin::class, 'usunWideoPotwierdz']);
    Route::post('admin/usunVideo/{id}', [Admin::class, 'usunWideoPotwierdzPOST']);
    Route::get('admin/sponsorzy', [Admin::class, 'sponsorzy']);
    Route::get('admin/sponsorzy/dodaj', [Admin::class, 'sposorzyDodaj']);
    Route::post('admin/sponsorzy/dodaj', [Admin::class, 'sposorzyDodajPOST']);
    Route::post('admin/sponsorzy/usun/{id}', [Admin::class, 'sponsorzyUsun']);
    Route::get('admin/sponsorzy/edycja/{id}', [Admin::class, 'sponsorzyEdycja']);
    Route::post('admin/sponsorzy/edycja/{id}', [Admin::class, 'sponsorzyEdycjaPOST']);
});


//404

Route::any('{query}',
    function() { return redirect('/'); })
    ->where('query', '.*');