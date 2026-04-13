@extends('user.theme')
@section('tresci')
    <section>
        <div class="gap black-layer opc8 overlap144">
            <div class="fixed-bg2" style="background-image: url(/upload/blog/cars-burning-scaled.jpg); background-attachment:fixed;"></div>
            <div class="container">
                <div class="pg-tp-wrp">
                    <h1 itemprop="headline">{{$tytul}}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" title="" itemprop="url">Start</a></li>
                        <li class="breadcrumb-item active">{{$tytul}}</li>
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
                            <h3>Wybierz interesujący moduł</h3>
                            @foreach ($konkursy as $q)
                            <div class="col-md-4 col-sm-6 col-lg-4 float-left" style="height:500px;">
                                <div class="blg-bx">
                                    <div class="blg-thmb"><a href="/konkurs/{{$q -> url}}" title="{{$q -> tytul}}" itemprop="url"><img src="{{$q -> zdjecie}}" alt="{{$q -> tytul}}" itemprop="image"></a></div>
                                    <div class="blg-inf">
                                        <h6 itemprop="headline"><a href="/konkurs/{{$q -> url}}" title="" itemprop="url">{{$q -> tytul}}</a></h6>
                                        <ul class="pst-mta">
                                            <li><i class="fas fa-user"></i><a href="/konkurs/{{$q -> url}}" title="" itemprop="url">Mateusz Ratajczak</a></li>
                                        </ul>
                                        <p itemprop="description">{{$q -> opis}}</p>
                                        <a href="/konkurs/{{$q -> url}}" title="" itemprop="url">Wybierz</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection