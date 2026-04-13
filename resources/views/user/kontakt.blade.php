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
                        <li class="breadcrumb-item active">Kontakt</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="gap">
            <div class="container">
                <div class="cnt-wrp">
                    <div class="row">
                        {!!$komunikat!!}
                        <div class="col-md-8 col-sm-12 col-lg-8">
                            <div class="cnt-frm">
                                <h4 itemprop="headline">Napisz do nas</h4>
                                <form method="POST" id="formularzKonktaktowy">
                                    {!! RecaptchaV3::field('register') !!}
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-lg-12">
                                            <input id="imie" type="text" name="imie" placeholder="Imie...">
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12">
                                            <input id="email" type="email" name="email" placeholder="E-mail">
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12">
                                            <input id="telefon" type="text" name="telefon" placeholder="Telefon...">
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12">
                                            <textarea id="tresc" name="tresc" placeholder="Treść wiadomości"></textarea>
                                        </div>
                                    </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12">
                                            <label id="zgodaForm" style="padding:2%; "><input type="checkbox" id="zgoda" style="height:16px !important; float:left; display:unset; width: auto; margin-right: 15px; margin-top: 5px;"> Wyrażam zgodę na przetwarzanie moich danych, zgodnie z <a href="/polityka-prywatnosci" target="_blank">polityką prywatności</a> strony.</label>
                                        </div>
                                    <div class="cnt-frm">
                                        <div class="col-md-12 col-sm-12 col-lg-12">
                                            <a id="wysylka" class="theme-btn brd-rd5 text-white" style="cursor:pointer; float:right;">Wyślij</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-lg-4">
                            <div class="cnt-inf-wrp">
                                <h4 itemprop="headline">Dane kontaktowe</h4>
                                <ul class="cnt-inf-lst">
                                    <li><i class="fas fa-envelope theme-clr"></i> <strong>E-mail</strong><a href="mailto:biuro@osp-swierzawa.pl" title="" itemprop="url">biuro@osp-swierzawa.pl</a></li>
                                    <li><i class="fas fa-map-marker-alt theme-clr"></i> <strong>OSP Świerzawa</strong><span>ul. Złotoryjska 23A<br />59-540 Świerzawa</span></li>
                                    <li><i class="fas fa-phone theme-clr"></i> <strong>Telefon</strong><span>tel. / fax: 75 7 135 338</span></li>
                                </ul>
                                <div class="scl4">
                                    <a href="https://www.facebook.com/ospswierzawa" title="Facebook" itemprop="url" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.instagram.com/osp_swierzawa/" title="Instagram" itemprop="url" target="_blank"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/js/kontakt.js"></script>
@endsection