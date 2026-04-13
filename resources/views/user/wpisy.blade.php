@extends('user.theme')
@section('tresci')
        <section>
            <div class="gap black-layer opc8 overlap144">
                <div class="fixed-bg2" style="background-image: url(/upload/blog/cars-burning-scaled.jpg); background-attachment:fixed;"></div>
                <div class="container">
                    <div class="pg-tp-wrp">
                        <h1 itemprop="headline">{{$co}}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/" title="" itemprop="url">Start</a></li>
                            <li class="breadcrumb-item active">{{$co}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap">
                <div class="container">
                    <div class="blg-sec remove-ext5">
                        <div class="row">
                            @foreach ($wpisy as $wpis)
                                @php
                                    $autor = DB::table('users')->where('id', $wpis -> autor)->first();
                                    $wstep = App\Http\Controllers\Blog::tylkoWstep($wpis -> tresc);
                                @endphp
                            <div class="col-md-4 col-sm-6 col-lg-4 wpisBlog">
                                <div class="blg-bx">
                                    <div class="blg-thmb" style="height: 250px; background:url({{$wpis -> zdjecie}}) no-repeat; background-size:cover;"></div>
                                    <div class="blg-inf">
                                        <h6 itemprop="headline"><a href="/b/{{$wpis -> url}}" title="{{$wpis -> tytul}}" itemprop="url">{{$wpis -> tytul}}</a></h6>
                                        <ul class="pst-mta">
                                            <li><i class="fas fa-user"></i><a href="#" title="" itemprop="url">{{$autor -> imie}} {{$autor -> nazwisko}}</a></li>
                                        </ul>
                                        <p itemprop="description">{{strip_tags($wstep)}}</p>
                                        <a href="/b/{{$wpis -> url}}" title="" itemprop="url">Przeczytaj</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div id="noweDodaj">

                            </div>
                        </div>
                    </div><!-- Blog Sec -->
                    @php
                        if($wszystkich > 10){
                            $stronnicowanie = '<li class="page-item"><a id="pokazWiecejWpisow" data-src="'.request()->segment(1).'" class="theme-btn brd-rd30" itemprop="url" style="color:#fff; cursor:pointer;">POKAŻ WIĘCEJ</a></li>';
                        }else{
                            $stronnicowanie = '';
                        }
                    @endphp
                    <div class="pgn-wrp text-center">
                        <ul class="pagination">
                            {!!$stronnicowanie!!}
                        </ul>
                    </div><!-- Pagination Wrap -->
                </div>
            </div>
        </section>
@endsection