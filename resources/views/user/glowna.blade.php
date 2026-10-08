@extends('user.theme')
@section('tresci')
<section>
    <div class="gap no-gap">
        <div class="featured-area-wrap text-center">
            <div class="featured-car owl-carousel">
                @foreach ($slider as $q)
                    <div class="featured-item" style="background-image: url({{$q->zdjecie}});">
                        <div class="featured-cap">
                            <span>{{$q->tytul}}</span>
                            <h2>{{$q->tytul}}</h2>
                            <div class="btns-grp">
                                <a class="theme-btn brd-rd30" href="/b/{{$q->url}}" title="">Czytaj</a>
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
                                <span>Bogu na chwałę, ludziom na ratunek</span>
                                <h2 itemprop="headline">OSP <span class="theme-clr">Świerzawa</span></h2>
                            </div>
                            <div class="abt-desc">
                                <p itemprop="description">Ochotnicza Straż Pożarna w Świerzawie jest największą jednostką na terenie gminy. Jesteśmy w strukturach Krajowego Systemu Ratowniczo-Gaśniczego. Można zaryzykować stwierdzenie, że jest zarazem „małym posterunkiem PSP” na południu powiatu złotoryjskiego.</p>
                                <p itemprop="description">Specyfika rejonu i spora odległość od JRG PSP w Złotoryi powodują, że OSP w Świerzawie musi radzić sobie z większością zdarzeń – przynajmniej w ich pierwszej fazie – sama lub przy współudziale innych jednostek gminy.</p>
                                <a href="/kontakt" class="theme-btn brd-rd30 float-right">KONTAKT</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 col-lg-5">
                        <div class="abt-img style2">
                            <img src="/assets/images/mainAll.jpg" alt="OSP Świerzawa" itemprop="image" loading="lazy" width="400" height="300">
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
                <span>Na nas możesz liczyć zawsze</span>
                <h2 itemprop="headline">Czy <span class="theme-clr">wiesz, że?</span></h2>
            </div>
            <div class="srv-wrp remove-ext7">
                <div class="row">
                    @php
                        $srvItems = [
                            ['icon' => 'srv-icn1-1.png', 'title' => 'Zadania specjalne', 'desc' => 'Nasze działania bywają niekiedy niebezpieczne, jednak odpowiedni sprzęt dba o nasze względne bezpieczeństwo.'],
                            ['icon' => 'srv-icn1-2.png', 'title' => 'Sprzęt gaśniczy', 'desc' => 'Nieustannie dbamy o to, by nasz sprzęt był zawsze gotowy do działań. Dzięki temu możecie czuć się bezpiecznie.'],
                            ['icon' => 'srv-icn1-3.png', 'title' => 'Pomoc przedmedyczna', 'desc' => 'Nasze szkolenia to nie tylko techniki gaszenia pożarów. Szkolimy się w wielu dziedzinach, w tym w pierwszej pomocy.'],
                            ['icon' => 'srv-icn1-4.png', 'title' => 'Nie tak lekko', 'desc' => 'Czy wiesz, że pełne umundurowanie strażaka (wraz z AODO) waży około 20 kg? Waga ta zwiększa się, gdy mundur nasiąknie wodą!'],
                            ['icon' => 'srv-icn1-5.png', 'title' => 'Jeśli nas widzisz', 'desc' => 'Czy wiesz, że masz obowiązek ustąpienia nam pierwszeństwa podczas przejazdu alarmowego? Pamiętaj, aby robić to z głową!'],
                            ['icon' => 'srv-icn1-6.png', 'title' => 'Nie zawsze gasimy', 'desc' => 'Czy wiesz, że nie wszystkie pożary powinny być gaszone od razu? Są takie rodzaje działań, w których pożar gasi się dopiero w końcowej fazie.'],
                            ['icon' => 'srv-icn1-7.png', 'title' => 'Zwracamy uwage', 'desc' => 'Pamiętaj, że wszelki sprzęt gaśniczy wymaga terminowych przeglądów. To narzędzie, które może uratować Ci życie lub majątek.'],
                            ['icon' => 'srv-icn1-8.png', 'title' => 'Zawsze na straży', 'desc' => 'Nie gniewaj się, gdy nie mamy ochoty rozmawiać po działaniach. Po wielu z nich jedyne, o czym w danej chwili możemy myśleć, to kąpiel i sen.'],
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
                <h2 itemprop="headline">Włącz <span class="theme-clr">myślenie</span></h2>
            </div>
            <div class="camp-wrp">
                <div class="camp-car owl-carousel">
                    @foreach ($kampanie as $q)
                    <div class="camp-bx">
                        <div class="camp-thmb">
                            <a href="/b/{{$q->url}}" title="{{$q->tytul}}" itemprop="url"><img src="{{$q->zdjecie}}" alt="{{$q->tytul}} - OSP Świerzawa" itemprop="image" loading="lazy" width="350" height="250"></a>
                            <div class="camp-inf">
                                <h5 itemprop="headline"><a href="/b/{{$q->url}}" title="{{$q->tytul}}" itemprop="url">{{$q->tytul}}</a></h5>
                            </div>
                        </div>
                        <div class="camp-btn">
                            <a class="theme-btn brd-rd5" href="/b/{{$q->url}}" title="{{$q->tytul}}" itemprop="url">Czytaj</a>
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
            <span>Nagrania od mieszkańców i nie tylko.</span>
            <h2 itemprop="headline">Wideo, które otrzymujemy od Was</h2>
        </div>
        <div class="vdo-sec-wrp">
            <div class="vdo-car owl-carousel">
                @foreach ($filmy as $film)
                <div class="vdo-bx">
                    <div class="vdo-thmb">
                        @if (!empty($film->miniatura))
                            <img src="{{$film->miniatura}}" alt="{{$film->tytul}}" itemprop="image" loading="lazy" width="300" height="200">
                        @else
                            <video src="{{$film->url_video}}#t=1" preload="metadata" muted playsinline disablepictureinpicture tabindex="-1" aria-hidden="true"></video>
                        @endif
                    </div>
                    <a href="{{$film->url_video}}" data-fancybox="gallery" title="{{$film->tytul}}" itemprop="url"><i class="flaticon-play-button"></i></a>
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
                <span>Ostatnie informacje udostępniane przez nas</span>
                <h2 itemprop="headline">Wydarzenia &amp; <span class="theme-clr">Działania</span></h2>
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
                                        <div class="blg-thmb"><a href="/b/{{$q->url}}" title="" itemprop="url"><img src="{{$q->zdjecie}}" alt="{{$q->tytul}} - OSP Świerzawa" itemprop="image" loading="lazy" width="250" height="180"></a></div>
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
                                <span>Bierzemy udział w wielu różnorodnych działaniach ratowniczo-gaśniczych i nie tylko.</span>
                                <h2 itemprop="headline">Nasze statystyki</h2>
                            </div>
                            <p itemprop="description">Nasze działania to nie tylko pożary, ale także powodzie czy podtopienia. Zaliczają się do nich również wypadki, zabezpieczanie miejsc zdarzeń i wiele innych.</p>
                            <ul class="stat-grid">
                                @foreach ($statystyki as $q)
                                <li class="stat-bx">
                                    <span class="counter">{{$q['iloscDzialan']}}</span>
                                    <h6 itemprop="headline">{{$q['kategoria']}}</h6>
                                </li>
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
                <span>Nie wiesz, co robić? Dowiedz się, zanim będziesz musiał/a coś zrobić!</span>
                <h2 itemprop="headline">Moduł <span class="theme-clr">nauki</span></h2>
            </div>
            <div class="tem-sec remove-ext5 text-center">
                <div class="row justify-content-center">
                    @foreach ($testy as $q)
                    <div class="col-md-4 col-sm-6 col-lg-4">
                        <div class="tm-bx">
                            <div class="tm-thmb">
                                <a href="/konkurs/{{$q->url}}" title="{{$q->tytul}}" itemprop="url"><img src="{{$q->zdjecie}}" alt="{{$q->tytul}} - testy wiedzy z OSP Świerzawa" itemprop="image" loading="lazy" width="300" height="200"></a>
                            </div>
                            <div class="tm-inf nauka-inf">
                                <h5 itemprop="headline"><a href="/konkurs/{{$q->url}}" title="" itemprop="url">{{$q->tytul}}</a></h5>
                                <p>{{$q->opis}}</p>
                                <a href="/konkurs/{{$q->url}}" class="theme-btn brd-rd5">Przejdź do modułu</a>
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

<style>
    /* Włącz myślenie - slider */
    .camp-car .owl-stage{display:flex;}
    .camp-car .owl-item{display:flex;}
    .camp-car .camp-bx{display:flex;flex-direction:column;float:none;}
    .camp-car .camp-thmb{float:none;aspect-ratio:7/5;}
    .camp-car .camp-thmb > a,
    .camp-car .camp-thmb img{display:block;width:100%;height:100%;object-fit:cover;}
    .camp-car .camp-inf h5{line-height:1.35;}
    .camp-car .camp-inf h5 a{color:#fff;}
    .camp-btn{margin-top:18px;text-align:center;}
    .camp-btn .theme-btn{padding:10px 30px;}
    .camp-car .owl-dots{text-align:center;margin-top:25px;}
    .camp-car .owl-dot{display:inline-block;}
    .camp-car .owl-dot span{display:block;width:12px;height:12px;margin:0 5px;border-radius:50%;background:#ccc;transition:all .2s;}
    .camp-car .owl-dot.active span{background:#f01313;width:28px;border-radius:6px;}

    /* Wideo - miniatury z filmu */
    .vdo-thmb{position:relative;aspect-ratio:16/10;background:#111;overflow:hidden;}
    .vdo-thmb img,
    .vdo-thmb video{display:block;width:100%;height:100%;object-fit:cover;pointer-events:none;}
    .vdo-bx > a{z-index:2;}
    .vdo-bx:before{z-index:1;opacity:.35;}
    .vdo-bx > h3{position:absolute;left:0;right:0;bottom:0;z-index:2;margin:0;padding:12px 15px;font-size:16px;color:#fff;background:linear-gradient(to top, rgba(0,0,0,.75), rgba(0,0,0,0));}

    /* Nasze statystyki */
    .stat-grid{display:grid;grid-template-columns:repeat(3, 1fr);gap:15px;padding:0;margin:30px 0 0;list-style:none;}
    .stat-bx{display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:25px 10px;border:1px solid rgba(255,255,255,.25);border-radius:10px;background:rgba(255,255,255,.06);}
    .stat-bx .counter{font-family:montserrat;font-weight:700;font-size:44px;line-height:1;color:#fff;position:relative;padding-bottom:12px;}
    .stat-bx .counter:after{content:"";position:absolute;left:50%;bottom:0;width:25px;height:3px;margin-left:-12.5px;background:#f01313;}
    .stat-bx h6{margin:14px 0 0;font-size:14px;font-weight:700;line-height:1.3;color:#fff;}
    @media (max-width: 575px){
        .stat-grid{grid-template-columns:1fr;}
    }

    /* Moduł nauki */
    .tem-sec .row > [class*="col-"]{display:flex;}
    .tem-sec .tm-bx{display:flex;flex-direction:column;float:none;}
    .tem-sec .tm-thmb{float:none;aspect-ratio:3/2;}
    .tem-sec .tm-thmb > a,
    .tem-sec .tm-thmb img{display:block;width:100%;height:100%;object-fit:cover;}
    .nauka-inf{display:flex;flex-direction:column;align-items:center;flex:1;margin-left:auto;margin-right:auto;padding-top:20px;}
    .nauka-inf h5{margin-bottom:10px;}
    .nauka-inf p{margin-bottom:20px;}
    .nauka-inf .theme-btn{margin-top:auto;}
</style>
<script>
    $(function () {
        if (!$.fn.owlCarousel) return;
        $('.camp-car').owlCarousel({
            loop: $('.camp-car .camp-bx').length > 3,
            margin: 30,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 700,
            responsive: {
                0: {items: 1},
                576: {items: 2},
                992: {items: 3}
            }
        });
    });
</script>

{{-- Widget "Nasze OSP używa OSPanel.pl" - wyłączony na czas głosowania osp-harnas.pl
<script src="https://ospanel.pl/widget-partner.js"
  data-code="2TKPXTHV"
  data-style="1"
  data-placement="bottom-right"
  data-desktop="15"
  data-mobile="30"
  data-radius="12" async></script>
--}}
@endsection
