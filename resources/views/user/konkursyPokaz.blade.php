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
                            <h3 id="tytul1" class="text-center">Zaznaczaj odpowiedzi</h3>
                            <p id="podtytul1" class="text-center">Test jest jednokrotnego wyboru, pytania są losowane z bazy pytań a sam wynik otrzymasz na wskazany adres e-mail.<br /><br /><strong style="color:red;">Jeśli podasz nam swój adres e-mail, na zakończenie otrzymasz dokładną rozpiskę z testu, wraz z Twoimi odpowiedziami oraz z tymi które powinny być właściwe.</strong></p>
                            <div id="trescPytan" class="text-center">
                                <div id="loader">
                                    <img src="/assets/images/fire.gif" alt="OSP Świerzawa"/>
                                </div>
                                <div id="trescPytanWlasciwa" class="col-md-8 offset-2" style="display:none;">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Wprowadź swój adres e-mail..."/><br /><br />
                                    <div id="podswietlZgoda" style="padding:5%;">
                                        <input type="checkbox" name="zgodaPolityka" id="zgodaPolityka"/> - Wyrażam zgodę na przetwarzanie moich danych w myśl <a href="/polityka-prywatnosci" target="_blank">polityki prywatności</a> naszej strony.
                                    </div>
                                    <br /><br />
                                    <input type="hidden" name="ip" id="ip" class="form-control" value="{{request()->ip()}}"/>
                                    <input type="hidden" name="url" value="{{request()->segment(2)}}"/>
                                    <a id="rozpocznijTest" class="btn btn-dark text-white">Przejdź do testu</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection