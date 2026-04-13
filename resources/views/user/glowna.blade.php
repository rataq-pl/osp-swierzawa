@extends('user.theme')
@section('tresci')
<section>
    <div class="gap no-gap">
        <div class="featured-area-wrap text-center">
            <div class="featured-car owl-carousel">
                    <!--<div class="featured-item" style="background-image: url(/elektro-smieci/ES_OSP_zbiorka.png);">
                        <div class="featured-cap" style="padding: 5%;
                        background: rgba(0,0,0,0.4);
                        border-radius: 25px;">
                            <span>Zbiórka elektro-śmieci</span>
                            <h2>Przyjmiemy elektro-śmieci</span></h2>
                            <p></p>
                            <div class="btns-grp">
                                <a class="theme-btn brd-rd30" href="/zbiorka-elektro-smieci-osp-swierzawa" title="">Czytaj</a>
                            </div>
                        </div>
                    </div>-->
                @foreach ($slider as $q)
                    <div class="featured-item" style="background-image: url({{$q -> zdjecie}});">
                        <div class="featured-cap" style="padding: 5%;
                        background: rgba(0,0,0,0.4);
                        border-radius: 25px;">
                            <span>{{$q -> tytul}}</span>
                            <h2>{{$q -> tytul}}</span></h2>
                            <p></p>
                            <div class="btns-grp">
                                <a class="theme-btn brd-rd30" href="/b/{{$q -> url}}" title="">Czytaj</a>
                                <a class="wht-btn brd-rd30" href="/dzialania-ratownicze" title="">Działania</a>
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
                                <span>Bogu na chwałę &amp; ludziom na ratunek</span>
                                <h2 itemprop="headline">OSP <span class ="theme-clr">Świerzawa</span></h2>
                            </div><!-- Sec Title -->
                            <div class="abt-desc">
                                <p itemprop="description">Ochotnicza Straż Pożarna w Świerzawie jest największą jednostką na terenie gminy. Jesteśmy w strukturach Krajowego Systemu Ratowniczo-Gaśniczego. Można zaryzykować stwierdzeniem, że jest zarazem „małym posterunkiem PSP” na południu powiatu złotoryjskiego.</p>
                                <p itemprop="description">Specyfika rejonu i spora odległość od JRG PSP w Złotoryi powoduje, że OSP w Świerzawie musi radzić sobie z większością zdarzeń przynajmniej w pierwszej ich fazie sama lub przy współudziale innych jednostek gminy..</p>
                                <a href="/kontakt" class="theme-btn brd-rd30 float-right">KONTAKT</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 col-lg-5">
                        <div class="abt-img style2">
                            <img src="/assets/images/mainAll.jpg" alt="OSP Świerzawa" itemprop="image">
                        </div>
                    </div>
                </div>
            </div><!-- About Sec -->
        </div>
    </div>
</section>

<section>
    <div class="gap gray-bg">
        <div class="container">
            <div class="sec-tl text-center">
                <span>Na nas możesz liczyć zawsze</span>
                <h2 itemprop="headline">Czy <span class ="theme-clr">wiesz że?</span></h2>
            </div><!-- Sec Title -->
            <div class="srv-wrp remove-ext7">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx text-center">
                            <i class="brd-rd50"><img src="/assets/images/resources/srv-icn1-1.png" alt="srv-icn1-1.png" itemprop="image"></i>
                            <div class="srv-inf">
                                <h5 itemprop="headline">Zadania specjalne</h5>
                                <p itemprop="description">Nasze działania bywają niekiedy niebezpieczne, jednak odpowiedni sprzęt dba o nasze względne bezpieczeństwo.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx">
                            <i class="brd-rd50"><img src="/assets/images/resources/srv-icn1-2.png" alt="srv-icn1-2.png" itemprop="image"></i>
                            <div class="srv-inf text-center">
                                <h5 itemprop="headline">Sprzęt gaśniczy</h5>
                                <p itemprop="description">Nieustannie dbamy o to, by nasz sprzęt był zawsze gotowy doo działań. Dzięki temu możecie czuć się bezpiecznie.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx">
                            <i class="brd-rd50"><img src="/assets/images/resources/srv-icn1-3.png" alt="srv-icn1-3.png" itemprop="image"></i>
                            <div class="srv-inf text-center">
                                <h5 itemprop="headline">Pomoc przedmedyczna</h5>
                                <p itemprop="description">Nasze szkolenia, to nie tylko techniki gaszenia pożarów. Szkolimy się w wielu dziedzinach, w tym pierwszej pomocy.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx">
                            <i class="brd-rd50"><img src="/assets/images/resources/srv-icn1-4.png" alt="srv-icn1-4.png" itemprop="image"></i>
                            <div class="srv-inf text-center">
                                <h5 itemprop="headline">Nie tak lekko</h5>
                                <p itemprop="description">Czy wiesz że pełne umundurowanie strażaka (wraz z AODO) waży około 20kg? Waga ta zwiększa się gdy mundur nasiąknie wodą!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx">
                            <i class="brd-rd50 text-center"><img src="/assets/images/resources/srv-icn1-5.png" alt="srv-icn1-5.png" itemprop="image"></i>
                            <div class="srv-inf text-center">
                                <h5 itemprop="headline">Jeśli nas widzisz</h5>
                                <p itemprop="description">Czy wiesz że masz obowiązek ustąpienia nam pierwszeństwa przejazdu podczas przejazdu alarmowego? Pamiętaj aby robić to z głową!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx">
                            <i class="brd-rd50"><img src="/assets/images/resources/srv-icn1-6.png" alt="srv-icn1-6.png" itemprop="image"></i>
                            <div class="srv-inf text-center">
                                <h5 itemprop="headline">Nie zawsze gasimy</h5>
                                <p itemprop="description">Czy wiesz że nie wszystkie pożary powinny być gaszone od razu? Jest wiele rodzai tego typu działań, gdzie pożar gasi się tylko w końcowej fazie.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx">
                            <i class="brd-rd50"><img src="/assets/images/resources/srv-icn1-7.png" alt="srv-icn1-7.png" itemprop="image"></i>
                            <div class="srv-inf text-center">
                                <h5 itemprop="headline">Zwracamy uwagę</h5>
                                <p itemprop="description">Pamiętaj że wszelki sprzęt gaśniczy wymaga terminowych przeglądów. Pamiętaj że to jedyne narzędzie które może Ci uratować życie lub majątek.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="srv-bx">
                            <i class="brd-rd50"><img src="/assets/images/resources/srv-icn1-8.png" alt="srv-icn1-8.png" itemprop="image"></i>
                            <div class="srv-inf text-center">
                                <h5 itemprop="headline">Zawsze na straży</h5>
                                <p itemprop="description">Nie gniewaj się gdy nie mamy ochoty rozmawiać po działaniach. Po wielu działaniach, jedyne o czym w danej chwili możemy myśleć to kąpiel i sen.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vw-al text-center">
                <a class="theme-btn brd-rd5" href="/kampanie" title="" itemprop="url">Kampanie społeczne</a>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="gap">
        <div class="container">
            <div class="sec-tl text-center">
                <span>Człowiek uczy się całe życie!</span>
                <h2 itemprop="headline">Włącz <span class ="theme-clr">myślenie</span></h2>
            </div>
            <div class="camp-wrp remove-ext5">
                <div class="row">
                    @foreach ($kampanie as $q)
                    <div class="col-md-4 col-sm-6 col-lg-4">
                        <div class="camp-bx">
                            <div class="camp-thmb">
                                <a href="/b/{{$q -> id}}/{{$q -> url}}" title="{{$q -> tytul}}" itemprop="url"><img src="{{$q -> zdjecie}}" alt="{{$q -> tytul}} - OSP Świerzawa" itemprop="image"></a>
                                <div class="camp-inf">
                                    <h5 itemprop="headline"><a href="/b/{{$q -> url}}" title="{{$q -> tytul}}" itemprop="url">{{$q -> tytul}}</a></h5>
                                </div>
                            </div>
                            <div class="prg-wrp">
                                <a class="theme-btn brd-rd5" href="/b/{{$q -> url}}" title="" itemprop="url" style="min-height: 40px;">Czytaj</a>
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
        <div class="fixed-bg" style="background-image: url(assets/images/parallax1.jpg);"></div>
        <div class="sec-tl text-center">
            <span>Nagrania od mieszkańców i nie tylko.</span>
            <h2 itemprop="headline">Wideo które otrzymujemy od Was</h2>
        </div><!-- Sec Title -->
        <div class="vdo-sec-wrp">
            <div class="vdo-car owl-carousel">
                @foreach ($filmy as $film)
                    <div class="vdo-bx">
                        <img src="/assets/images/resources/vdo-img1-1.jpg" alt="vdo-img1-1.jpg" itemprop="image">
                        <a href="{{$film -> url_video}}" data-fancybox="gallery" title="" itemprop="url"><i class="flaticon-play-button"></i></a>
                        <h3>{{$film -> tytul}}</h3>
                    </div>
                @endforeach
            </div>
        </div><!-- Video Sec Wrap -->
    </div>
</section>
<section>
    <div class="gap remove-gap">
        <div class="container">
            <div class="sec-tl text-center">
                <span>Ostatnie informacje udostępniane przez nas</span>
                <h2 itemprop="headline">Wydarzenia & <span class ="theme-clr">Działania</span></h2>
            </div><!-- Sec Title -->
            <div class="blg-evnt-wrp">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="remove-ext5">
                            <div class="row">
                                @foreach ($zdarzenia as $q)
                                    @php
                                        $autor = $q -> autor;
                                        $autor = DB::table('users')->select('id', 'imie', 'nazwisko')->where('id', $autor)->first();    
                                    @endphp
                                <div class="col-md-6 col-sm-6 col-lg-6">
                                    <div class="blg-bx">
                                        <div class="blg-thmb"><a href="/b/{{$q -> url}}" title="" itemprop="url"><img src="{{$q -> zdjecie}}" alt="{{$q -> tytul}} - OSP Świerzawa" itemprop="image"></a></div>
                                        <div class="blg-inf">
                                            <h6 itemprop="headline"><a href="/b/{{$q -> url}}" title="" itemprop="url">{{$q -> tytul}}</a></h6>
                                            <ul class="pst-mta">
                                                <li><i class="fas fa-user"></i><a href="#" title="" itemprop="url">{{$autor -> imie}} {{$autor -> nazwisko}}</a></li>
                                            </ul>
                                            <a href="/b/{{$q -> url}}" title="" itemprop="url">Czytaj</a>
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
                                        $autor = $a -> autor;
                                        $autor = DB::table('users')->select('id', 'imie', 'nazwisko')->where('id', $autor)->first();
                                    @endphp
                            <div class="evnt-bx">
                                <div class="evnt-inf">
                                    <h5 itemprop="headline">
                                        <a href="/b/{{$a -> url}}" title="{{$a -> tytul}}" itemprop="url">{{$a -> tytul}}</a>
                                    </h5>
                                    <ul class="pst-mta">
                                        <li>
                                            <i class="fas fa-user"></i>
                                            <a href="#" title="" itemprop="url">{{$autor -> imie}} {{$autor -> nazwisko}}</a>
                                        </li>
                                    </ul>
                                    <a class = "event-btn" href="/b/{{$a -> url}}" title="" itemprop="url">Czytaj</a>
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
        <div class="fixed-bg" style="background-image: url(assets/images/para-new.png);"></div>
        <div class="container">
            <div class="shrt-fcts-wrp">
                <div class="row">
                    
                    <div class="col-md-5 col-sm-12 col-lg-5">
                    <img class ="facts-mockup animated bounce" src = "assets/images/fact-mockup.png" alt="mockup-image">
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="fcts-wrp">
                            <div class="sec-tl">
                                <span>Bierzemy udział w wielu różnorodnych działaniach ratowniczo-gaśniczych i nie tylko.</span>
                                <h2 itemprop="headline">Nasze statystyki</h2>
                            </div><!-- Sec Title -->
                            <p itemprop="description">Nasze działania, to nie tylko pożary ale także powodzie czy podtopienia. Zaliczają się do nich także wypadki, zabezpieczenia miejsc zdarzeń i nie tylko.</p>
                            <ul class="fcts-lst">
                                @foreach ($statystyki as $q)
                                    <li style="font-size: 14px"><span class="counter">{{$q['iloscDzialan']}}</span><h6 itemprop="headline" style="font-size: 14px">{{$q['kategoria']}}</h6></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-12 col-lg-1"></div>
                </div>
            </div><!-- Short Facts Wrap -->
        </div>
    </div>
</section>
<section>
    <div class="gap">
        <div class="container">
            <div class="sec-tl text-center">
                <span>Nie wiesz co robić? Dowiedz się zanim będziesz musiał/a coś zrobić!</span>
                <h2 itemprop="headline">Moduł <span class ="theme-clr">Nauki</span></h2>
            </div><!-- Sec Title -->
            <div class="tem-sec remove-ext5 text-center">
                <div class="row">
                    @foreach ($testy as $q)
                        <div class="col-md-4 col-sm-6 col-lg-4">
                            <div class="tm-bx">
                                <div class="tm-thmb">
                                    <a href="/konkurs/{{$q -> url}}" title="" itemprop="url"><img src="{{$q -> zdjecie}}" alt="{{$q -> tytul}} - testy wiedzy z OSP Świerzawa" itemprop="image"></a>
                            </div>
                            <div class="tm-inf">
                                <h5 itemprop="headline"><a href="/konkurs/url" title="" itemprop="url">{{$q -> tytul}}</a></h5>
                                <span class="theme-clr">{{$q -> opis}}</span>
                                <span class="theme-clr"><a href="/konkurs/{{$q -> url}}" class="theme-btn brd-rd5">Przejdź do modułu</a></span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div><!-- Team Sec -->
        </div>
        <a class="floter-911" href="#" title="" itemprop="url"><img src="/assets/images/911-icon.png" alt="911-icon.png" itemprop="image"></a>
    </div>
</section>
@endsection