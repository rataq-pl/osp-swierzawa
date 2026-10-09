<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.css" integrity="sha512-+1GzNJIJQ0SwHimHEEDQ0jbyQuglxEdmQmKsu8KI7QkMPAnyDrL9TAnVyLPEttcTxlnLVzaQgxv2FpLCLtli0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Oficjalna strona internetowa - OSP Swierzawa" />
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
    <link rel="stylesheet" href="/assets/css/colors/color.css" title="color" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anton&display=swap">

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
        cursor: pointer;
    }
    a.wspierajModal:hover{
        color: #f01313;
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
        z-index:99999;
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
        z-index:99999;
    }
    .fanimani_:hover{
        width:10%;
        padding:17px;
    }
    .featured-cap{
        max-width: min(700px, calc(100% - 32px));
        padding: 30px 40px;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 25px;
    }
    .featured-cap > h2{
        font-size: clamp(22px, 4.2vw, 52px);
        line-height: 1.2;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    .featured-cap > h2 + .btns-grp{
        margin-top: 20px;
    }
    @media (max-width: 767px){
        .featured-cap{
            padding: 20px;
        }
    }
    .harnas-tlo{
        position: fixed;
        inset: 0;
        z-index: 999999;
        background: rgba(0, 0, 0, 0.75);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .harnas-okno{
        position: relative;
        width: 100%;
        max-width: 480px;
        max-height: 100%;
        overflow-y: auto;
        background: #0d1630;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }
    .harnas-okno img{
        display: block;
        width: 100%;
        height: auto;
    }
    .harnas-zamknij{
        position: absolute;
        top: 8px;
        right: 8px;
        width: 36px;
        height: 36px;
        line-height: 34px;
        text-align: center;
        font-size: 28px;
        color: #fff !important;
        background: #f01313;
        cursor: pointer;
        z-index: 2;
    }
    .harnas-zamknij:hover{
        opacity: 0.7;
    }
    .harnas-dol{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 16px;
        color: #fff;
    }
    .harnas-modal-dane{
        font-size: 15px;
        line-height: 1.4;
    }
    .harnas-modal-dane b{
        color: #fdd23a;
        font-size: 18px;
    }
    .harnas-btn{
        flex-shrink: 0;
        display: block;
        padding: 10px 20px;
        background: #e3312d;
        color: #fff !important;
        font-family: 'Anton', sans-serif;
        font-size: 18px;
        letter-spacing: 1px;
        text-align: center;
        text-transform: uppercase;
        transition: all .3s ease;
    }
    .harnas-btn:hover{
        background: #fdd23a;
        color: #0d1630 !important;
    }
    .harnas-licznik{
        position: fixed;
        left: 16px;
        bottom: 2%;
        z-index: 99999;
        width: 210px;
        padding: 14px;
        background: linear-gradient(160deg, #0a0f24 0%, #16224a 100%);
        border-bottom: 4px solid #e3312d;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        color: #fff;
        text-align: center;
    }
    .harnas-tag{
        display: inline-block;
        padding: 2px 8px;
        background: #e3312d;
        font-family: 'Anton', sans-serif;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    .harnas-licznik-tytul{
        margin: 6px 0 8px;
        font-family: 'Anton', sans-serif;
        font-size: 24px;
        line-height: 1.1;
        text-transform: uppercase;
    }
    .harnas-licznik-tytul span{
        color: #fdd23a;
    }
    .harnas-licznik-dane{
        display: flex;
        gap: 8px;
        margin-bottom: 10px;
    }
    .harnas-licznik-dane div{
        flex: 1;
        padding: 6px 4px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 6px;
    }
    .harnas-licznik-dane b{
        display: block;
        color: #fdd23a;
        font-family: 'Anton', sans-serif;
        font-size: 26px;
        font-weight: normal;
        line-height: 1.1;
    }
    .harnas-licznik-dane small{
        font-size: 11px;
        color: #b9c3e0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .harnas-awans{
        display: none;
        margin: 6px 0 10px;
        padding: 6px 8px;
        font-size: 13px;
        line-height: 1.35;
        color: #fff;
        background: rgba(240, 19, 19, 0.85);
        border-radius: 6px;
    }
    .harnas-awans b{
        color: #fdd23a;
    }
    .harnas-modal-dane .harnas-awans{
        margin: 8px 0 4px;
        font-size: 14px;
    }
    .harnas-modal-dane .harnas-awans b{
        font-size: inherit;
    }
    .harnas-licznik-info{
        margin-top: 6px;
        font-size: 11px;
        color: #b9c3e0;
    }
    .harnas-sync{
        margin-top: 4px;
        font-size: 10px;
        color: #8592b8;
    }
    .harnas-sync span{
        white-space: nowrap;
    }
    .harnas-sync:empty{
        display: none;
    }
    @media (max-width: 767px){
        /* na telefonie kompaktowy pasek na dole ekranu */
        .harnas-licznik{
            left: 16px;
            right: 16px;
            bottom: 2%;
            width: auto;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            text-align: left;
        }
        .harnas-tag, .harnas-licznik-info{
            display: none;
        }
        .harnas-licznik-tytul{
            margin: 0;
            font-size: 15px;
            line-height: 1.05;
        }
        .harnas-licznik-tytul span{
            display: block;
        }
        .harnas-licznik-dane{
            margin: 0;
            gap: 6px;
        }
        .harnas-licznik-dane div{
            padding: 2px 6px;
            text-align: center;
        }
        .harnas-licznik-dane b{
            font-size: 18px;
        }
        .harnas-licznik-dane small{
            font-size: 9px;
            letter-spacing: 0;
        }
        .harnas-licznik .harnas-sync{
            position: absolute;
            right: 0;
            bottom: 100%;
            margin: 0;
            padding: 2px 8px;
            background: #0a0f24;
            font-size: 9px;
        }
        .grecaptcha-badge{
            visibility: hidden !important;
        }
        .harnas-licznik .harnas-btn{
            margin-left: auto;
            padding: 8px 10px;
            font-size: 14px;
            white-space: nowrap;
        }
    }
</style>
<body itemscope>

    <div class="preloader" style="z-index:99999;">
        <div class="loader-inner ball-scale-multiple">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <main>
        <header class="stick">
            <div class="tb-br">
                <div class="container">
                    <div class="scl1 col-6 float-left">
                        <a href="https://www.facebook.com/ospswierzawa" title="Facebook" itemprop="url" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/osp_swierzawa/" title="Instagram" itemprop="url" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@jagoda2883" title="TikTok" itemprop="url" target="_blank" rel="noopener"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                    <ul class="tp-lst col-6 float-right">
                        <li id="buttonNaviWspieraj" style="padding-left: 3%; padding-right: 3%;"><i class="fas fa-hand-holding-heart theme-clr"></i><a href="#" id="wsparcieOSP" class="wspierajModal" title="" itemprop="url">Wspieraj nas</a></li>
                        <li><i class="fas fa-envelope theme-clr"></i><a href="mailto:biuro@osp-swierzawa.pl" title="" itemprop="url">biuro@osp-swierzawa.pl</a></li>
                        <li><i class="flaticon-telephone theme-clr"></i>75 713 53 38</li>
                    </ul>
                </div>
            </div>
            <div class="lg-mnu-sec sticky">
                <div class="container">
                    <div class="logo"><a href="/" title="Logo" itemprop="url"><img src="/assets/images/logo.png" alt="OSP Swierzawa logo" itemprop="image"></a></div>
                    <nav>
                        <div>
                            <ul>
                                <li class="menu-item-has-children"><a class="brd-rd3" href="#" title="" itemprop="url">Witaj <i class="fas fa-angle-down"></i></a>
                                    <ul>
                                        <li><a href="/dzialania-ratownicze" title="" itemprop="url">Aktualnosci</a></li>
                                        <li><a href="/kampanie" title="" itemprop="url">Kampanie</a></li>
                                        <li><a href="/historia" title="" itemprop="url">Historia</a></li>
                                        <li><a href="/zarzad" title="" itemprop="url">Zarzad</a></li>
                                        <li><a href="/wyposazenie" title="" itemprop="url">Wyposazenie</a></li>
                                        <li><a href="/statut" title="" itemprop="url">Statut</a></li>
                                    </ul>
                                </li>
                                <li><a href="/MDP" title="" itemprop="url">MDP</a></li>
                                <li><a href="/dokumenty" title="" itemprop="url">Dokumenty</a></li>
                                <li><a href="/kontakt" title="" itemprop="url">Kontakt</a></li>
                                <li class="menu-item-has-children"><a href="#" title="" itemprop="url">Warte uwagi <i class="fas fa-angle-down"></i></a>
                                    <ul>
                                        <li><a href="/jakosc-powietrza" title="" itemprop="url">Jakosc powietrza</a></li>
                                        <li><a href="/konkurs" title="" itemprop="url">Sprawdziany wiedzy</a></li>
                                        <li><a href="/pdf/harmonogram2023.pdf" target="_blank" rel="noopener" title="" itemprop="url">Harmonogram zebran 2023</a></li>
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
                    <li><a href="https://www.instagram.com/osp_swierzawa/" title="Instagram" itemprop="url" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://www.facebook.com/ospswierzawa" title="Facebook" itemprop="url" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a></li>
                </ul>
            </div>
            <div class="lg-mn">
                <div class="logo"><a href="/" title="Logo" itemprop="url"><img src="/assets/images/logo2.png" alt="OSP Swierzawa logo" itemprop="image"></a></div>
                <div class="rspn-cnt">
                    <span><i class="fas fa-envelope theme-clr"></i><a href="mailto:biuro@osp-swierzawa.pl" title="" itemprop="url">biuro@osp-swierzawa.pl</a></span>
                    <span><i class="flaticon-telephone theme-clr"></i>75 713 53 38</span>
                </div>
                <span class="rspn-mnu-btn brd-rd5"><i class="fa fa-list-ul"></i></span>
            </div>
            <div class="rsnp-mnu">
                <span class="rspn-mnu-cls"><i class="fa fa-times"></i></span>
                <ul style="height: 100% !important;">
                    <li class="menu-item-has-children"><a class="brd-rd3" href="#" title="" itemprop="url">Witaj <i class="fas fa-angle-down"></i></a>
                        <ul>
                            <li><a href="/historia" title="" itemprop="url">Historia</a></li>
                            <li><a href="/zarzad" title="" itemprop="url">Zarzad</a></li>
                            <li><a href="/wyposazenie" title="" itemprop="url">Wyposazenie</a></li>
                            <li><a href="/statut" title="" itemprop="url">Statut</a></li>
                        </ul>
                    </li>
                    <li><a href="/kampanie" title="" itemprop="url">Kampanie</a></li>
                    <li><a href="/MDP" title="" itemprop="url">MDP</a></li>
                    <li><a href="/dzialania-ratownicze" title="" itemprop="url">Dzialania</a></li>
                    <li><a href="/dokumenty" title="" itemprop="url">Dokumenty</a></li>
                    <li><a href="/kontakt" title="" itemprop="url">Kontakt</a></li>
                    <li class="menu-item-has-children"><a href="#" title="" itemprop="url">Warte uwagi <i class="fas fa-angle-down"></i></a>
                        <ul>
                            <li><a href="/jakosc-powietrza" title="" itemprop="url">Jakosc powietrza</a></li>
                            <li><a href="/sprawdzian" title="" itemprop="url">Sprawdziany wiedzy</a></li>
                            <li><a href="/pdf/harmonogram2023.pdf" target="_blank" rel="noopener" title="" itemprop="url">Harmonogram zebran 2023</a></li>
                        </ul>
                    </li>
                    <li><a href="/wsparcie" class="wsparcie bg-danger text-white" title="" itemprop="url">Wsparcie</a></li>
                </ul>
            </div>
        </div>

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
                                            <h5 itemprop="headline">Na skroty</h5>
                                            <ul>
                                                <li><a href="/historia" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Historia</a></li>
                                                <li><a href="/zarzad" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Zarzad</a></li>
                                                <li><a href="/wyposazenie" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Nasze wyposazenie</a></li>
                                                <li><a href="/statut" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Statut</a></li>
                                                <li><a href="/dokumenty" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Dokumenty</a></li>
                                                <li><a href="/polityka-prywatnosci" title="" itemprop="url"><i class="fas fa-angle-double-right"></i>Polityka prywatnosci</a></li>
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
                                                    <a href="/konkurs/{{$q->url}}" title="" itemprop="url"><img src="{{$q->zdjecie}}" alt="{{$q->tytul}}" itemprop="image" loading="lazy"></a>
                                                    <div class="ltst-nws-inf">
                                                        <h6 itemprop="headline"><a href="/konkurs/{{$q->url}}" title="" itemprop="url">{{$q->tytul}}</a></h6>
                                                        <span><a href="/konkurs/{{$q->url}}" title="" itemprop="url">{{$q->opis}}</a></span>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <div class="btm-br drk-bg">
            <div class="container">
                <div class="cpyrgt float-left"><p itemprop="description"><a href="https://rataq.pl" title="" itemprop="url" target="_blank" rel="noopener">RATAQ.PL - Tworzenie i pozycjonowanie stron internetowych</a> &copy; 2021 - {{ date("Y") }} / OSP Swierzawa</p></div>
                <div class="scl-sbcrb float-right">
                    <div class="scl3">
                        <a href="https://www.facebook.com/ospswierzawa" title="Facebook" itemprop="url" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/osp_swierzawa/" title="Instagram" itemprop="url" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    {{-- Ikonki 1,5% i Fanimani - wyłączone na czas głosowania osp-harnas.pl
    <a href="/b/wsparcie-osp-swierzawa-twoj-gest-moze-uratowac-zycie" target="_blank" rel="noopener" class="percent_">
        <img src="/1-5_procent_podatku.jpg" alt="Przekaz 1,5%" loading="lazy">
    </a>

    <a href="https://osp-swierzawa.pl/b/wspieraj-osp-swierzawa-robiac-zakupy-online-program-fanimani-pl" target="_blank" rel="noopener" class="fanimani_">
        <img src="/fanimani.png" alt="Fanimani - wspieraj OSP Swierzawa" loading="lazy">
    </a>
    --}}

    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-select.min.js"></script>
    <script src="/assets/js/downCount.js"></script>
    <script src="/assets/js/counterup.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/fancybox.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script src="/assets/js/custom-scripts.js"></script>
    <script src="/js/rataqPLtesty.js"></script>
    <script src="/js/wpisy.js"></script>
    <script src="/js/rtqModal.js"></script>
    <script src="/js/harnas.js"></script>
    <script src="/assets/js/featherlight.js"></script>
    <script src="/assets/js/featherlight.gallery.js"></script>

    <script>
        $('#trescWpisu a').on('click', function(e) {
            if ($(this).hasClass('justLink')) {
                window.open($(this).attr('href'), '_blank');
            } else if ($(e.target).is('img')) {
                $(e.target).featherlight({
                    targetAttr: 'src'
                });
            }
            e.preventDefault();
        });

        $('#close_popup').on('click', function() {
            $('#popup').remove();
        });
    </script>

</body>
</html>
