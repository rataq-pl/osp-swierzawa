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
                        <li class="breadcrumb-item active">{{$q -> tytul}}</li>
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
                                    </ul>
                                </div>
                                <div id="trescWpisu" class="blog-detail-desc" style="font-size: 16pt; padding: 10% 1%;" data-featherlight-gallery data-featherlight-filter="a">
                                    {!!$tresc!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection