@extends('user.theme')

@section('tresci')

    @php

        $tresc = $q -> tresc;

        //czy jest iframe YT

        if(strpos($tresc, "[embedyt]") == false){

            //nie ma

        }else{

            $tresc2 = '';

            $tresc = explode('[embedyt]', $tresc);

            $cz1 = $tresc[0];

            $tresc = explode('[/embedyt]', $tresc[1]);

            $cz2 = $tresc[1];

            $link = $tresc[0];

            $link = '<a href="'.$link.'" target="_blank" class="theme-btn theme-bg">ZOBACZ FILM</a>';

            $tresc = $cz1.'<br />'.$link.'<br />'.$cz2;

        }

            $tresc = str_replace('<img', '<img data-featherlight="image"', $tresc);

    @endphp

    <section>

        <div class="gap black-layer opc8 overlap144">

            <div class="fixed-bg2" style="background-image: url(/upload/blog/cars-burning-scaled.jpg); background-attachment:fixed;"></div>

            <div class="container">

                <div class="pg-tp-wrp">

                    <h1 itemprop="headline">{{$tytul}}</h1>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="/" title="" itemprop="url">Start</a></li>

                        <li class="breadcrumb-item active">{{$q -> kategoria}}</li>

                    </ol>

                </div>

            </div>

        </div>

    </section>

    <section>

        <style>

            figcaption{

                display:none !important;

            }

            figure.wp-block-image{

                display: block;

                float: left;

                width: 20%;

                margin-left:5px;

            }

        </style>

        <div class="gap">

            <div class="container">

                <div class="blog-detail-wrp">

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-lg-12">

                            <div class="blog-detail">

                                <div class="event-detail-img brd-rd5">

                                    <img src="{{$q -> zdjecie}}" alt="{{$q -> tytul}} - OSP Świerzawa" itemprop="image" style="width:100%;">

                                </div>

                                <div class="blog-detail-inf">

                                    <h3 class="title" style="padding-top:2%;">{{$q -> tytul}}</h3>

                                    <ul class="pst-mta">

                                        <li><i class="fas fa-user theme-clr"></i>{{$autor -> imie}} {{$autor -> nazwisko}}</li>

                                    </ul>

                                </div>
                                @if (count($video) > 0)
                                    <div class="col-12 d-flex flex-wrap justify-content-center align-items-center align-content-center pt-5">
                                        @foreach ($video as $v)
                                            <div class="col-8">
                                                <video class="col-12" controls>
                                                    <source src="{{asset($v -> url)}}" type="video/mp4"/>
                                                </video>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div id="trescWpisu" class="blog-detail-desc" style="font-size: 16pt; padding: 1% 1%; position:relative; z-index:9999999;" data-featherlight-gallery data-featherlight-filter="a">

                                    {!!$tresc!!}

                                    <a class="justLink" href="https://osp-swierzawa.pl/b/wspieraj-osp-swierzawa-robiac-zakupy-online-program-fanimani-pl" target="_blank" style="width:100%; display:flex; justify-content:center; margin-top:50px;">
                                        <img src="/assets/images/osp.jpg" alt="OSP Świerzawa - fanimani - info"/>
                                    </a>
                                </div>


                                <style>

                                    ul#light-slider:{

                                        width:100%;
                                        height:auto !important;
                                    }

                                    .clearfix{

                                        clear:both;

                                    }

                                    .lSNext{

                                        margin-right: 15%;

                                    }

                                    .lSPrev{

                                        margin-left: 15%;

                                    }

                                </style>

                                <div class="col-md-12" style="margin-bottom:10%;">

                                    <ul id="light-slider" style="height:auto !important;">

                                        @foreach ($zdjecia as $fota)

                                            <li>

                                                <img src="{{$fota -> url}}" class="col-md-12"/>

                                            </li>

                                        @endforeach

                                    </ul>

                                </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.js" integrity="sha512-sww7U197vVXpRSffZdqfpqDU2SNoFvINLX4mXt1D6ZecxkhwcHmLj3QcL2cJ/aCxrTkUcaAa6EGmPK3Nfitygw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <script type="text/javascript">

        $(document).ready(function() {

        $("#light-slider").lightSlider({
            item: 1,
            autoWidth: false,
            slideMove: 1, // slidemove will be 1 if loop is true
            slideMargin: 0,
            addClass: 'clearfix',
            adaptiveheight: true,
            verticalHeight: 800
        })

        })

        document.addEventListener('contextmenu', event => event.preventDefault());
        window.addEventListener('load', function(){
            setInterval(function(){
                var zdjecieAktywne = document.getElementsByClassName('lslide');
            if(zdjecieAktywne.length > 0){
                for(var i=0;i<zdjecieAktywne.length;i++){
                    if(zdjecieAktywne[i].classList.contains('active')){
                        var q = zdjecieAktywne[i]
                        var img = q.getElementsByTagName('img')
                        img = img[0]
                        var wysokosc = img.offsetHeight
                        $('#light-slider').css('height', wysokosc+'px')
                    }
                }
            }
            }, 200)
        });
    </script>

                                <div class="blg-sec remove-ext5">

                                    <div class="sec-tl text-center">

                                        <span>Chcesz zobaczyć podobne informacje?</span>

                                        <h2 itemprop="headline">Zobacz <span class="theme-clr">jeszcze</span></h2>

                                    </div>

                                    @foreach ($inne as $item)

                                        @php

                                            if(!isset($juz)){

                                                $juz = 1;

                                            }else{

                                                $juz++;

                                            }

                                            if($juz == 5){

                                                echo '<div class="clearfix"></div>';

                                            }else{}

                                            $autorTeraz = DB::table('users')->where('id', $item -> autor)->first();

                                            $wstep = App\Http\Controllers\Blog::tylkoWstep($item -> tresc);

                                        @endphp

                                    <div class="col-md-3 col-sm-6 col-lg-3" style="display:block !important; float:left;">

                                        <div class="blg-bx">

                                            <div class="blg-thmb"><a href="/b/{{$item -> url}}" title="{{$item -> zdjecie}}" itemprop="url"><img src="{{$item -> zdjecie}}" alt="{{$item -> tytul}} - OSP Świerzawa" itemprop="image" style="width:100%;"></a></div>

                                            <div class="blg-inf">

                                                <h6 itemprop="headline"><a href="/b/{{$item -> url}}" title="" itemprop="url">{{$item -> tytul}}</a></h6>

                                                <ul class="pst-mta">

                                                    <li><i class="fas fa-user"></i><a href="/b/{{$item -> url}}" title="" itemprop="url">{{$autorTeraz -> imie}} {{$autorTeraz -> nazwisko}}</a></li>

                                                </ul>

                                                <p itemprop="description">{{Str::limit(strip_tags($wstep), 150)}}</p>

                                                <a href="/b/{{$item -> url}}" title="" itemprop="url">Czytaj</a>

                                            </div>

                                        </div>

                                    </div>

                                    @endforeach

                                </div>

                                <div class="blg-sec remove-ext5" style="padding-top:15%;">

                                    <div class="sec-tl text-center">

                                        <span>Jeśli masz ochotę, ucz się z nami!</span>

                                        <h2 itemprop="headline">Sprawdź czy <span class="theme-clr">wiesz!</span></h2>

                                    </div>

                                    @foreach ($testy as $item)

                                    <div class="col-md-4 col-sm-6 col-lg-4" style="display:block; float:left;">

                                        <div class="blg-bx">

                                            <div class="blg-thmb"><a href="/konkurs/{{$item -> url}}" title="{{$item -> zdjecie}}" itemprop="url"><img src="{{$item -> zdjecie}}" alt="{{$item -> tytul}} - OSP Świerzawa" itemprop="image" style="width:100%;"></a></div>

                                            <div class="blg-inf">

                                                <h6 itemprop="headline"><a href="/konkurs/{{$item -> url}}" title="" itemprop="url">{{$item -> tytul}}</a></h6>

                                                <p itemprop="description">{{$item -> opis}}</p>

                                                <a href="/konkurs/{{$item -> url}}" title="" itemprop="url">Sprawdź się</a>

                                            </div>

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

    </section>

@endsection
