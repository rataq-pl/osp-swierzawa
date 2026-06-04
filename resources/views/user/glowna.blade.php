@extends('user.theme')
@section('tresci')
<section>
    <div class="gap no-gap">
        <div class="featured-area-wrap text-center">
            <div class="featured-car owl-carousel">
                @foreach ($slider as $q)
                    <div class="featured-item" style="background-image: url({{$q->zdjecie}});">
                        <div class="featured-cap" style="padding: 5%; background: rgba(0,0,0,0.4); border-radius: 25px;">
                            <span>{{$q->tytul}}</span>
                            <h2>{{$q->tytul}}</h2>
                            <div class="btns-grp">
                                <a class="theme-btn brd-rd30" href="/b/{{$q->url}}" title="">Czytaj</a>
                                <a class="wht-btn brd-rd30" href="/dzialania-ratownicze" title="">Dzialania</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section>
    <div class="gap">
        <div class="container">
            <div class="abt-sec style-edit">
                <div class="row">
                    <div class="col-md-7 col-sm-12 col-lg-7">
                        <div class="abt-cnt">
                            <div class="sec-tl">
                                <span>Bogu na chwale &amp; ludziom na ratunek</span>
                                <h2 itemprop="headline">OSP <span class="theme-clr">Swieriawa</span></h2>
                            </div>
                            <div class="abt-desc">
                                <p itemprop="description">Ochotnicza Straz Pozarna w Swieriawie jest najwieksza jednostka na terenie gminy. Jestesmy w strukturach Krajowego Systemu Ratowniczo-Gasniczego. Mozna zaryzykowac stwierdzeniem, ze jest zarazem "malym posterunkiem PSP" na poludniu powiatu zlotoryjskiego.</p>
                                <p itemprop="description">Specyfika rejonu i spora odleglosc od JRG PSP w Zlotoryi powoduje, ze OSP w Swieriawie musi radzic sobie z wiekszoscia zdarzen przynajmniej w pierwszej ich fazie sama lub przy wspoludziale innych jednostek gminy.</p>
                                <a href="/kontakt" class="theme-btn brd-rd30 float-right">KONTAKT</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 col-lg-5">
                        <div class="abt-img style2">
                            <img src="/assets/images/mainAll.jpg" alt="OSP Swieriawa" itemprop="image" loading="lazy" width="400" height="300">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="gap gray-bg">
        <div class="container">
            <div class="sec-tl text-center">
                <span>Na nas mozesz liczyc zawsze</span>
                <h2 itemprop="headline">Czy <span class="theme-clr">wiesz ze?</span></h2>
            </div>
            <div class="srv-wrp remove-ext7">
                <div class="row">
                    @php
                        $srvItems = [
                            ['icon' => 'srv-icn1-1.png', 'title' => 'Zadania specjalne', 'desc' => 'Nasze dzialania bywaja niekiedy niebezpieczne, jednak odpowiedni sprzet dba o nasze wzgledne bezpieczenstwo.'],
                            ['icon' => 'srv-icn1-2.png', 'title' => 'Sprzet gasniczy', 'desc' => 'Nieustannie dbamy o to, by nasz sprzet byl zawsze gotowy do dzialan. Dzieki temu mozecie czuc sie bezpiecznie.'],
                            ['icon' => 'srv-icn1-3.png', 'title' => 'Pomoc przedmedyczna', 'desc' => 'Nasze szkolenia, to nie tylko techniki gaszenia pozarow. Szkolimy sie w wielu dziedzinach, w tym pierwszej pomocy.'],
                            ['icon' => 'srv-icn1-4.png', 'title' => 'Nie tak lekko', 'desc' => 'Czy wiesz ze pelne umundurowanie strazaka (wraz z AODO) wazy okolo 20kg? Waga ta zwieksza sie gdy mundur nasiaknie woda!'],
                            ['icon' => 'srv-icn1-5.png', 'title' => 'Jesli nas widzisz', 'desc' => 'Czy wiesz ze masz obowiazek ustapienia nam pierwszenstwa przejazdu podczas przejazdu alarmowego? Pamietaj aby robic to z glowa!'],
                            ['icon' => 'srv-icn1-6.png', 'title' => 'Nie zawsze gasimy', 'desc' => 'Czy wiesz ze nie wszystkie pozary powinny byc gaszone od razu? Jest wiele rodzajow tego typu dzialan, gdzie pozar gasi sie tylko w koncowej fazie.'],
                            ['icon' => 'srv-icn1-7.png', 'title' => 'Zwracamy uwage', 'desc' => 'Pamietaj ze wszelki sprzet gasniczy wymaga terminowych przegladow. Pamietaj ze to jedyne narzedzie ktore moze Ci uratowac zycie lub majatek.'],
                            ['icon' => 'srv-icn1-8.png', 'title' => 'Zawsze na strazy', 'desc' => 'Nie gniewaj sie gdy nie mamy ochoty rozmawiac po dzialaniach. Po wielu dzialaniach, jedyne o czym w danej chwili mozemy myslec to kapiel i sen.'],
                        ];
                    @endphp
                    @foreach($srvItems as $item)
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx text-center">
                            <i class="brd-rd50"><img src="/assets/images/resources/{{$item['icon']}}" alt="{{$item['title']}}" itemprop="image" loading="lazy" width="60" height="60"></i>
                            <div class="srv-inf">
                                <h5 itemprop="headline">{{$item['title']}}</h5>
                                <p itemprop="description">{{$item['desc']}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="vw-al text-center">
                <a class="theme-btn brd-rd5" href="/kampanie" title="" itemprop="url">Kampanie spoleczne</a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="gap">
        <div class="container">
            <div class="sec-tl text-center">
                <span>Czlowiek uczy sie cale zycie!</span>
                <h2 itemprop="headline">Wlacz <span class="theme-clr">myslenie</span></h2>
            </div>
            <div class="camp-wrp remove-ext5">
                <div class="row">
                    @foreach ($kampanie as $q)
                    <div class="col-md-4 col-sm-6 col-lg-4">
                        <div class="camp-bx">
                            <div class="camp-thmb">
                                <a href="/b/{{$q->url}}" title="{{$q->tytul}}" itemprop="url"><img src="{{$q->zdjecie}}" alt="{{$q->tytul}} - OSP Swieriawa" itemprop="image" loading="lazy" width="350" height="250"></a>
                                <div class="camp-inf">
                                    <h5 itemprop="headline"><a href="/b/{{$q->url}}" title="{{$q->tytul}}" itemprop="url">{{$q->tytul}}</a></h5>
                                </div>
                            </div>
                            <div class="prg-wrp">
                                <a class="theme-btn brd-rd5" href="/b/{{$q->url}}" title="" itemprop="url" style="min-height: 40px;">Czytaj</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="gap theme-bg-layer opc9 hlf-parallax">
        <div class="fixed-bg" style="background-image: url(/assets/images/parallax1.jpg);"></div>
        <div class="sec-tl text-center">
            <span>Nagrania od mieszkancow i nie tylko.</span>
            <h2 itemprop="headline">Wideo ktore otrzymujemy od Was</h2>
        </div>
        <div class="vdo-sec-wrp">
            <div class="vdo-car owl-carousel">
                @foreach ($filmy as $film)
                <div class="vdo-bx">
                    <img src="/assets/images/resources/vdo-img1-1.jpg" alt="Film" itemprop="image" loading="lazy" width="300" height="200">
                    <a href="{{$film->url_video}}" data-fancybox="gallery" title="" itemprop="url"><i class="flaticon-play-button"></i></a>
                    <h3>{{$film->tytul}}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section>
    <div class="gap remove-gap">
        <div class="container">
            <div class="sec-tl text-center">
                <span>Ostatnie informacje udostepniane przez nas</span>
                <h2 itemprop="headline">Wydarzenia & <span class="theme-clr">Dzialania</span></h2>
            </div>
            <div class="blg-evnt-wrp">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="remove-ext5">
                            <div class="row">
                                @foreach ($zdarzenia as $q)
                                @php
                                    $autor = DB::table('users')->select('id', 'imie', 'nazwisko')->where('id', $q->autor)->first();
                                @endphp
                                <div class="col-md-6 col-sm-6 col-lg-6">
                                    <div class="blg-bx">
                                        <div class="blg-thmb"><a href="/b/{{$q->url}}" title="" itemprop="url"><img src="{{$q->zdjecie}}" alt="{{$q->tytul}} - OSP Swieriawa" itemprop="image" loading="lazy" width="250" height="180"></a></div>
                                        <div class="blg-inf">
                                            <h6 itemprop="headline"><a href="/b/{{$q->url}}" title="" itemprop="url">{{$q->tytul}}</a></h6>
                                            <ul class="pst-mta">
                                                <li><i class="fas fa-user"></i><a href="#" title="" itemprop="url">{{$autor->imie ?? ''}} {{$autor->nazwisko ?? ''}}</a></li>
                                            </ul>
                                            <a href="/b/{{$q->url}}" title="" itemprop="url">Czytaj</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="evnt-wrp">
                            @foreach ($inne as $a)
                            @php
                                $autor = DB::table('users')->select('id', 'imie', 'nazwisko')->where('id', $a->autor)->first();
                            @endphp
                            <div class="evnt-bx">
                                <div class="evnt-inf">
                                    <h5 itemprop="headline">
                                        <a href="/b/{{$a->url}}" title="{{$a->tytul}}" itemprop="url">{{$a->tytul}}</a>
                                    </h5>
                                    <ul class="pst-mta">
                                        <li>
                                            <i class="fas fa-user"></i>
                                            <a href="#" title="" itemprop="url">{{$autor->imie ?? ''}} {{$autor->nazwisko ?? ''}}</a>
                                        </li>
                                    </ul>
                                    <a class="event-btn" href="/b/{{$a->url}}" title="" itemprop="url">Czytaj</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="gap black-layer opc8">
        <div class="fixed-bg" style="background-image: url(/assets/images/para-new.png);"></div>
        <div class="container">
            <div class="shrt-fcts-wrp">
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-lg-5">
                        <img class="facts-mockup animated bounce" src="/assets/images/fact-mockup.png" alt="mockup-image" loading="lazy" width="400" height="350">
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="fcts-wrp">
                            <div class="sec-tl">
                                <span>Bierzemy udzial w wielu roznorodnych dzialaniach ratowniczo-gasniczych i nie tylko.</span>
                                <h2 itemprop="headline">Nasze statystyki</h2>
                            </div>
                            <p itemprop="description">Nasze dzialania, to nie tylko pozary ale takze powodzie czy podtopienia. Zaliczaja sie do nich takze wypadki, zabezpieczenia miejsc zdarzen i nie tylko.</p>
                            <ul class="fcts-lst">
                                @foreach ($statystyki as $q)
                                <li style="font-size: 14px"><span class="counter">{{$q['iloscDzialan']}}</span><h6 itemprop="headline" style="font-size: 14px">{{$q['kategoria']}}</h6></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-12 col-lg-1"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="gap">
        <div class="container">
            <div class="sec-tl text-center">
                <span>Nie wiesz co robic? Dowiedz sie zanim bedziesz musial/a cos zrobic!</span>
                <h2 itemprop="headline">Modul <span class="theme-clr">Nauki</span></h2>
            </div>
            <div class="tem-sec remove-ext5 text-center">
                <div class="row">
                    @foreach ($testy as $q)
                    <div class="col-md-4 col-sm-6 col-lg-4">
                        <div class="tm-bx">
                            <div class="tm-thmb">
                                <a href="/konkurs/{{$q->url}}" title="" itemprop="url"><img src="{{$q->zdjecie}}" alt="{{$q->tytul}} - testy wiedzy z OSP Swieriawa" itemprop="image" loading="lazy" width="300" height="200"></a>
                            </div>
                            <div class="tm-inf">
                                <h5 itemprop="headline"><a href="/konkurs/{{$q->url}}" title="" itemprop="url">{{$q->tytul}}</a></h5>
                                <span class="theme-clr">{{$q->opis}}</span>
                                <span class="theme-clr"><a href="/konkurs/{{$q->url}}" class="theme-btn brd-rd5">Przejdz do modulu</a></span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <a class="floter-911" href="#" title="" itemprop="url"><img src="/assets/images/911-icon.png" alt="911-icon.png" itemprop="image" loading="lazy" width="50" height="50"></a>
    </div>
</section>

<script src="https://ospanel.pl/widget-partner.js"
  data-code="2TKPXTHV"
  data-style="1"
  data-placement="bottom-right"
  data-desktop="15"
  data-mobile="30"
  data-radius="12" async></script>
@endsection
