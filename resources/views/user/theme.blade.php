<!DOCTYPE html>

<html lang="pl">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.css" integrity="sha512-+1GzNJIJQ0SwHimHEEDQ0jbyQuglxEdmQmKsu8KI7QkMPAnyDrL9TAnVyLPEttcTxlnLVzaQgxv2FpLCLtli0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Oficjalna strona internetowa - OSP Świerzawa" />

    <meta name="keywords" content="" />

    <title>{{$tytul}}</title>

    <meta property="og:title" content="{{$tytul}}" />

    <meta property="og:image" content="{{App\Http\Controllers\Glowna::pokazZdjecieOG()}}" />

    <link rel="stylesheet" href="/assets/css/icons.min.css">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="/assets/css/style.css">

    <link rel="stylesheet" href="/assets/css/responsive.css">

    <link rel="stylesheet" href="/assets/css/featherlight.css">

    <link rel="stylesheet" href="/assets/css/featherlight.gallery.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="shortcut icon" type="image/png" href="/assets/images/favicon.png"/>



    <!-- Color Scheme -->

    <link rel="stylesheet" href="/assets/css/colors/color.css" title="color" /><!-- Color -->

    <link rel="alternate stylesheet" href="/assets/css/colors/color2.css" title="color2" /> <!-- Color2 -->

    <link rel="alternate stylesheet" href="/assets/css/colors/color3.css" title="color3" /> <!-- Color3 -->

    <link rel="alternate stylesheet" href="/assets/css/colors/color4.css" title="color4" /> <!-- Color4 -->


<script async src="https://www.googletagmanager.com/gtag/js?id=UA-40869548-3"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());



  gtag('config', 'UA-40869548-3');

</script>
<script src="/assets/js/jquery.min.js"></script>


{!! Lunaweb\RecaptchaV3\Facades\RecaptchaV3::initJs() !!}
</head>

<style>
    #zamknijOkno{
        padding: 5px 8px !important;
        background-color: #f01313;
        color: #fff;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 15px;
    }
    #zamknijOkno:hover{
        opacity: 0.6;
    }
    a.wspierajModal{
        cursor: 'pointer';
    }
    a.wspierajModal:hover{
        color: '#f01313';
    }
    li.blocks-gallery-item {

        display: block;

        width: 20%;

        float: left;

    }


    .percent_{
        width: 150px;
        display: flex;
        position: fixed;
        bottom: 2%;
        left: -1px;
        padding: 15px;
        border: solid 1px lightgrey;
        box-shadow: 15px 15px 50px lightgrey;
        transition: all 1s;
        z-index:99999999999;
        background:#fff;
    }
    .percent_:hover{
        width:10%;
        padding:17px;
    }

    .fanimani_{
        width: 150px;
        display: flex;
        position: fixed;
        bottom:2%;
        left:160px;
        padding: 15px;
        transition: all .5s ease;
        z-index:99999999999;
    }
    .fanimani_:hover{
        width:10%;
        padding:17px;
    }

</style>

<body itemscope>

    <div class="preloader" style="z-index:99999999;">

        <div class="loader-inner ball-scale-multiple">

            <div></div>

            <div></div>

            <div></div>

        </div>

    </div><!-- Preloader -->

    <main>

        <header class="stick">

            <div class="tb-br">

                <div class="container">

                    <div class="scl1 col-6 float-left">

                        <a href="https://www.facebook.com/ospswierzawa" title="Facebook" itemprop="url" target="_blank"><i class="fab fa-facebook-f"></i></a>

                        <a href="https://www.instagram.com/osp_swierzawa/" title="Instagram" itemprop="url" target="_blank"><i class="fab fa-instagram"></i></a>

                        <a href="https://www.tiktok.com/@jagoda2883" title="TikTok" itemprop="url" target="_blank"><i class="fa-brands fa-tiktok"></i></a>

                    </div>

                    <ul class="tp-lst col-6 float-right">

                        <li id="buttonNaviWspieraj" style="padding-left: 3%; padding-right: 3%;"><i class="fas fa-hand-holding-heart theme-clr"></i><a href="#" id="wsparcieOSP" class="wspierajModal" title="" itemprop="url">Wspieraj nas</a></li>

                        <li><i class="fas fa-envelope theme-clr"></i><a href="mailto:biuro@osp-swierzawa.pl" title="" itemprop="url">biuro@osp-swierzawa.pl</a></li>

                        <li><i class="flaticon-telephone theme-clr"></i>75 713 53 38</li>

                    </ul>

                </div>

            </div><!-- Topbar -->

            <div class="lg-mnu-sec sticky">

                <div class="container">

                    <div class="logo"><a href="/" title="Logo" itemprop="url"><img src="/assets/images/logo.png" alt="logo.png" itemprop="image"></a></div><!-- Logo -->

                    <nav>

                        <div>

                            <ul>
                                <li class = "menu-item-has-children"><a class="brd-rd3" href="#" title="" itemprop="url">Witaj <i class="fas fa-angle-down"></i></a>

									<ul>
        								<li><a href="/dzialania-ratownicze" title="" itemprop="url">Aktualności</a></li>

								        <li><a href="/kampanie" title="" itemprop="url">Kampanie</a></li>

                                        <li><a href="/historia" title="" itemprop="url">Historia</a></li>

                                        <li><a href="/zarzad" title="" itemprop="url">Zarząd</a></li>

                                        <li><a href="/wyposazenie" title="" itemprop="url">Wyposażenie</a></li>

                                        <li><a href="/statut" title="" itemprop="url">Statut</a></li>

                                    </ul>

								</li>


								<li><a href="/MDP" title="" itemprop="url">MDP</a></li>

								<li><a href="/dokumenty" title="" itemprop="url">Dokumenty</a></li>

								<li><a href="/kontakt" title="" itemprop="url">Kontakt</a></li>

								<li class="menu-item-has-children"><a href="#" title="" itemprop="url">Warte uwagi <i class="fas fa-angle-down"></i></a>

                                    <ul>

                                        <li><a href="/jakosc-powietrza" title="" itemprop="url">Jakość powietrza</a></li>

                                        <li><a href="/konkurs" title="" itemprop="url">Sprawdziany wiedzy</a></li>

								        <li><a href="/pdf/harmonogram2023.pdf" target="_blank" title="" itemprop="url">Harmonogram zebrań 2023</a></li>

                                    </ul>

                                </li>

								<li><a href="/wsparcie" class="wsparcie bg-danger text-white" title="" itemprop="url">Wsparcie</a></li>

                            </ul>

                        </div>

                    </nav>

                </div>

            </div>

        </header>

        <div class="rspn-hdr">

            <div class="rspn-mdbr">

                <ul class="rspn-scil">

                    <li><a href="https://www.instagram.com/osp_swierzawa/" title="Instagram" itemprop="url" target="_blank"><i class="fab fa-instagram"></i></a></li>

                    <li><a href="https://www.facebook.com/ospswierzawa" title="Facebook" itemprop="url" target="_blank"><i class="fab fa-facebook-f"></i></a></li>

                </ul>

            </div>

            <div class="lg-mn">

                <div class="logo"><a href="/" title="Logo" itemprop="url"><img src="/assets/images/logo2.png" alt="logo2.png" itemprop="image"></a></div>

                <div class="rspn-cnt">

                    <span><i class="fas fa-envelope theme-clr"></i><a href="mailto:biuro@osp-swierzawa.pl" title="" itemprop="url">biuro@osp-swierzawa.pl</a></span>

                    <span><i class="flaticon-telephone theme-clr"></i>75 713 53 38</span>

                </div>

                <span class="rspn-mnu-btn brd-rd5"><i class="fa fa-list-ul"></i></span>

            </div>

            <div class="rsnp-mnu">

                <span class="rspn-mnu-cls"><i class="fa fa-times"></i></span>

                <ul style="height: 100% !important;">
                    <li class = "menu-item-has-children"><a class="brd-rd3" href="#" title="" itemprop="url">Witaj <i class="fas fa-angle-down"></i></a>

                        <ul>

                            <li><a href="/historia" title="" itemprop="url">Historia</a></li>

                            <li><a href="/zarzad" title="" itemprop="url">Zarząd</a></li>

                            <li><a href="/wyposazenie" title="" itemprop="url">Wyposażenie</a></li>

                            <li><a href="/statut" title="" itemprop="url">Statut</a></li>

                        </ul>

                    </li>

                    <li><a href="/kampanie" title="" itemprop="url">Kampanie</a></li>

                    <li><a href="/MDP" title="" itemprop="url">MDP</a></li>

                    <li><a href="/dzialania-ratownicze" title="" itemprop="url">Działania</a></li>

                    <li><a href="/dokumenty" title="" itemprop="url">Dokumenty</a></li>

                    <li><a href="/kontakt" title="" itemprop="url">Kontakt</a></li>



                    <li class="menu-item-has-children"><a href="#" title="" itemprop="url">Warte uwagi <i class="fas fa-angle-down"></i></a>

                        <ul>

                            <li><a href="/jakosc-powietrza" title="" itemprop="url">Jakość powietrza</a></li>

                            <li><a href="/sprawdzian" title="" itemprop="url">Sprawdziany wiedzy</a></li>

								        <li><a href="/pdf/harmonogram2023.pdf" target="_blank" title="" itemprop="url">Harmonogram zebrań 2023</a></li>

                        </ul>

                    </li>

                    <li><a href="/wsparcie" class="wsparcie bg-danger text-white" title="" itemprop="url">Wsparcie</a></li>
                </ul>

            </div>

        </div><!-- Responsive Header -->

            @yield('tresci')

        <footer>

            <div class="gap drk-bg">

                <div class="container">

                    <div class="ftr-dta remove-ext5">

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-lg-12">

                                <div class="row">

                                    <div class="col-md-5 col-sm-5 col-lg-5">

                                        <div class="wdgt-bx">

                                            <h5 itemprop="headline">Na skróty</h5>

                                            <ul>

                                                <li><a href="/historia" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Historia</a></li>

                                                <li><a href="/zarzad" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Zarząd</a></li>

                                                <li><a href="/wyposazenie" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Nasze wyposażenie</a></li>

                                                <li><a href="/statut" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Statut</a></li>

                                                <li><a href="/dokumenty" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Dokumenty</a></li>

                                                <li><a href="/polityka-prywatnosci" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Polityka prywatności</a></li>

                                            </ul>

                                        </div>

                                    </div>

                                    <div class="col-md-7 col-sm-7 col-lg-7">

                                        <div class="wdgt-bx">

                                            <h5 itemprop="headline">Ostatnie testy</h5>

                                            <div class="ltst-wrp">

                                                @php

                                                    $sql = DB::table('testy')->orderByDesc('id')->limit(2)->get();

                                                @endphp

                                                @foreach ($sql as $q)

                                                <div class="ltst-nws-bx">

                                                    <a  href="/konkurs/{{$q -> url}}" title="" itemprop="url"><img src="{{$q -> zdjecie}}" alt="ltst-nws-img1-1.jpg" itemprop="image"></a>

                                                    <div class="ltst-nws-inf">

                                                        <h6 itemprop="headline"><a href="/konkurs/{{$q -> url}}" title="" itemprop="url">{{$q -> tytul}}</a></h6>

                                                        <span><a href="/konkurs/{{$q -> url}}" title="" itemprop="url">{{$q -> opis}}</a></span>

                                                    </div>

                                                </div>

                                                @endforeach

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div><!-- Footer Data -->

                </div>

            </div>

        </footer><!-- Footer -->

        <div class="btm-br drk-bg">

            <div class="container">

                <div class="cpyrgt float-left"><p itemprop="description"><a href="https://rataq.pl" title="" itemprop="url">RATAQ.PL - Tworzenie i pozycjonowanie stron internetowych</a> &copy; 2021 - <? echo date("Y");?> / OSP Świerzawa</p></div>

                <div class="scl-sbcrb float-right">

                    <div class="scl3">

                        <a href="https://www.facebook.com/ospswierzawa" title="Facebook" itemprop="url" target="_blank"><i class="fab fa-facebook-f"></i></a>

                        <a href="https://www.instagram.com/osp_swierzawa/" title="Instagram" itemprop="url" target="_blank"><i class="fab fa-instagram"></i></a>

                    </div>

                </div>

            </div>

        </div><!-- Bottom Bar -->

    </main><!-- Main Wrapper -->

    <a href="/b/wsparcie-osp-swierzawa-twoj-gest-moze-uratowac-zycie" target="_blank" class="percent_">
        <img src="/1-5_procent_podatku.jpg" alt="Przekaż 1,5%"/>
    </a>

    <a href="https://osp-swierzawa.pl/b/wspieraj-osp-swierzawa-robiac-zakupy-online-program-fanimani-pl" target="_blank" class="fanimani_">
        <img src="/fanimani.png" alt="Fanimani - wspieraj OSP Świerzawa"/>
    </a>

    <aside>
        @if(session()->get('popup') == null)
            @php
                session(['popup' => true]);
            @endphp
            <!--<div id="popup" style="display:none; position:fixed; z-index: 9999; left:0; top:0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display:flex; justify-content: center; align-items: center;">
                <button class="btn btn-dark" id="close_popup" style="position: absolute;
                top: 20px;
                right: 20px;
                box-shadow: -2px 2px 15px #000;">X</button>
                <a href="/zbiorka-elektro-smieci-osp-swierzawa">
                    <img src="/elektro-smieci/ES_OSP_zbiorka.png" style="max-height: 80%; max-width: 80%;"/>
                </a>
            </div>-->
        @endif
    </aside>

    <script src="/assets/js/bootstrap.min.js"></script>

    <script src="/assets/js/bootstrap-select.min.js"></script>

    <script src="/assets/js/downCount.js"></script>

    <script src="/assets/js/counterup.js"></script>

    <script src="/assets/js/owl.carousel.min.js"></script>

    <script src="/assets/js/perfect-scrollbar.min.js"></script>

    <script src="/assets/js/styleswitcher.js"></script>

    <script src="/assets/js/fancybox.min.js"></script>

    <script src="/assets/js/slick.min.js"></script>

    <script src="/assets/js/custom-scripts.js"></script>

    <script src="/js/rataqPLtesty.js"></script>
    <script src="/js/wpisy.js"></script>
    <script src="/js/rtqModal.js"></script>

    <script src="/assets/js/featherlight.js"></script>

    <script src="/assets/js/featherlight.gallery.js"></script>

    <script>
        $('#trescWpisu a').on('click', function(e) {
            if ($(this).hasClass('justLink')) {
                // Otwieramy link w nowej karcie bez popupu
                window.open($(this).attr('href'), '_blank');
            } else if ($(e.target).is('img')) {
                // Otwieramy popup z obrazkiem
                $(e.target).featherlight({
                    targetAttr: 'src'
                });
            } else {
                // Popup dla innych linków
                // Możesz tutaj dodać kod do otwierania popupu
            }
            e.preventDefault();
        });

        $('#close_popup').on('click', function() {
            $('#popup').remove();
        });
    </script>

</body>

</html>
