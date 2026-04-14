<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Oficjalna strona internetowa - OSP Świerzawa" />
    <meta name="keywords" content="" />
    <title>{{$tytul}}</title>
    <meta property="og:title" content="{{$tytul}}" />
    <meta property="og:image" content="{{App\Http\Controllers\Glowna::pokazZdjecieOG()}}" />

    <!-- Preload krytycznych zasobow -->
    <link rel="preload" href="/assets/css/bootstrap.min.css" as="style">
    <link rel="preload" href="/assets/css/style.css" as="style">
    <link rel="preload" href="/assets/js/jquery.min.js" as="script">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <!-- Krytyczne CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link rel="stylesheet" href="/assets/css/colors/color.css">

    <!-- Niekrytyczne CSS - lazy load -->
    <link rel="stylesheet" href="/assets/css/icons.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="/assets/css/featherlight.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="/assets/css/featherlight.gallery.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css" media="print" onload="this.media='all'" integrity="sha512-+1GzNJIJQ0SwHimHEEDQ0jbyQuglxEdmQmKsu8KI7QkMPAnyDrL9TAnVyLPEttcTxlnLVzaQgxv2FpLCLtli0A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <link rel="shortcut icon" type="image/png" href="/assets/images/favicon.png"/>

    <!-- Google Analytics - async -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-40869548-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-40869548-3');
    </script>

    {!! Lunaweb\RecaptchaV3\Facades\RecaptchaV3::initJs() !!}

    <style>
        /* Krytyczne style inline dla szybszego renderingu */
        body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif}
        .preloader{position:fixed;left:0;top:0;width:100%;height:100%;z-index:99999;background:#fff;display:flex;align-items:center;justify-content:center}
        .loader-inner div{width:15px;height:15px;background:#e74c3c;border-radius:50%;animation:ball-scale .8s infinite ease-in-out;display:inline-block;margin:0 5px}
        @keyframes ball-scale{0%,100%{transform:scale(0)}50%{transform:scale(1)}}
        #zamknijOkno{padding:5px 8px!important;background-color:#f01313;color:#fff;cursor:pointer;position:absolute;top:10px;right:15px}
        #zamknijOkno:hover{opacity:.6}
        a.wspierajModal{cursor:pointer}
        a.wspierajModal:hover{color:#f01313}
        li.blocks-gallery-item{display:block;width:20%;float:left}
        .percent_{width:150px;display:flex;position:fixed;bottom:2%;left:-1px;padding:15px;border:solid 1px lightgrey;box-shadow:15px 15px 50px lightgrey;transition:all 1s;z-index:99999;background:#fff}
        .percent_:hover{width:10%;padding:17px}
        .fanimani_{width:150px;display:flex;position:fixed;bottom:2%;left:160px;padding:15px;transition:all .5s ease;z-index:99999}
        .fanimani_:hover{width:10%;padding:17px}
        /* Lazy load placeholder */
        img[data-src]{opacity:0;transition:opacity .3s}
        img.loaded{opacity:1}
    </style>
</head>
<body itemscope>

    <div class="preloader" id="preloader" style="z-index:99999;">
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
                    <div class="logo"><a href="/" title="Logo" itemprop="url"><img src="/assets/images/logo.png" alt="OSP Świerzawa logo" itemprop="image" width="180" height="60"></a></div>
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
                <div class="logo"><a href="/" title="Logo" itemprop="url"><img src="/assets/images/logo2.png" alt="OSP Świerzawa logo" itemprop="image" width="120" height="40"></a></div>
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
                                                    <a href="/konkurs/{{$q->url}}" title="" itemprop="url"><img src="{{$q->zdjecie}}" alt="{{$q->tytul}}" itemprop="image" loading="lazy" width="80" height="60"></a>
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
                <div class="cpyrgt float-left"><p itemprop="description"><a href="https://rataq.pl" title="" itemprop="url" target="_blank" rel="noopener">RATAQ.PL - Tworzenie i pozycjonowanie stron internetowych</a> &copy; 2021 - {{ date("Y") }} / OSP Swieriawa</p></div>
                <div class="scl-sbcrb float-right">
                    <div class="scl3">
                        <a href="https://www.facebook.com/ospswierzawa" title="Facebook" itemprop="url" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/osp_swierzawa/" title="Instagram" itemprop="url" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <a href="/b/wsparcie-osp-swierzawa-twoj-gest-moze-uratowac-zycie" target="_blank" rel="noopener" class="percent_">
        <img src="/1-5_procent_podatku.jpg" alt="Przekaz 1,5%" loading="lazy" width="120" height="80">
    </a>

    <a href="https://osp-swierzawa.pl/b/wspieraj-osp-swierzawa-robiac-zakupy-online-program-fanimani-pl" target="_blank" rel="noopener" class="fanimani_">
        <img src="/fanimani.png" alt="Fanimani - wspieraj OSP Swieriawa" loading="lazy" width="120" height="80">
    </a>

    <!-- jQuery najpierw -->
    <script src="/assets/js/jquery.min.js"></script>

    <!-- Krytyczne skrypty dla slajdera i video - bez defer -->
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-select.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script src="/assets/js/fancybox.min.js"></script>
    <script src="/assets/js/custom-scripts.js"></script>

    <!-- Skrypty ladowane po zaladowaniu strony -->
    <script>
        // Szybkie ukrycie preloadera
        window.addEventListener('load', function() {
            var preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 300);
            }
        });

        // Lazy load dla obrazow bez natywnego wsparcia
        document.addEventListener('DOMContentLoaded', function() {
            // Native lazy loading fallback
            if ('loading' in HTMLImageElement.prototype) {
                // Browser wspiera natywne lazy loading
                var images = document.querySelectorAll('img[loading="lazy"]');
                images.forEach(function(img) {
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                    }
                });
            } else {
                // Fallback - Intersection Observer
                var lazyImages = document.querySelectorAll('img[data-src]');
                if ('IntersectionObserver' in window) {
                    var imageObserver = new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                var image = entry.target;
                                image.src = image.dataset.src;
                                image.classList.add('loaded');
                                imageObserver.unobserve(image);
                            }
                        });
                    }, {rootMargin: '50px 0px'});
                    lazyImages.forEach(function(image) {
                        imageObserver.observe(image);
                    });
                }
            }
        });
    </script>

    <!-- Niekrytyczne skrypty - ladowane po interakcji -->
    <script>
        var scriptsLoaded = false;
        function loadDeferredScripts() {
            if (scriptsLoaded) return;
            scriptsLoaded = true;

            var scripts = [
                '/assets/js/downCount.js',
                '/assets/js/counterup.js',
                '/assets/js/perfect-scrollbar.min.js',
                '/assets/js/featherlight.js',
                '/assets/js/featherlight.gallery.js',
                '/js/rataqPLtesty.js',
                '/js/wpisy.js',
                '/js/rtqModal.js'
            ];

            scripts.forEach(function(src) {
                var script = document.createElement('script');
                script.src = src;
                script.async = true;
                document.body.appendChild(script);
            });
        }

        // Laduj po pierwszej interakcji
        ['scroll', 'mousemove', 'touchstart', 'keydown'].forEach(function(event) {
            window.addEventListener(event, loadDeferredScripts, {once: true, passive: true});
        });

        // Lub po 3 sekundach
        setTimeout(loadDeferredScripts, 3000);
    </script>

    <script>
        // Featherlight dla galerii - po zaladowaniu
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof $ !== 'undefined') {
                $(document).on('click', '#trescWpisu a', function(e) {
                    if ($(this).hasClass('justLink')) {
                        window.open($(this).attr('href'), '_blank');
                    } else if ($(e.target).is('img') && typeof $.fn.featherlight !== 'undefined') {
                        $(e.target).featherlight({targetAttr: 'src'});
                    }
                    e.preventDefault();
                });

                $(document).on('click', '#close_popup', function() {
                    $('#popup').remove();
                });
            }
        });
    </script>

</body>
</html>
