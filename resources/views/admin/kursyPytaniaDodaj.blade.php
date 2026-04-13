@extends('admin.theme')
@section('tresci')
    <div class="starter-template">
        {!!$komunikat!!}
        <div class="col-md-6 offset-3">
            <form id="formularz" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <label>Pytanie:</label>
                <input type="text" name="tytul" class="form-control" placeholder="Wprowadź tytuł (np. Pierwsza pomoc)..."/>
                <label>Wyjaśnienie (jeśli potrzeba):</label>
                <input type="text" name="wyjasnienie" class="form-control" placeholder="Wprowadź wyjasnienie (dodatkowy opis który wyjaśnie kontekst pytania)..."/>
                
                <label>Odpowiedzi:</label>
                <div class="clearfix"></div>
                <div class="col-md-12 mozliwaOdpVal" style="margin:5% 0; min-height:100px;" id="odpVal0">
                    <div class="col-md-10 float-left">
                        <textarea name="odpowiedz1" class="odpowiedzi form-control" data-count="0" placeholder="Wprowadź odpowiedź..."></textarea>
                    </div>
                    <div class="col-md-2 float-left">
                        <a class="btn btn-warning oznaczWlasciwa" data-oznacz="0" onclick="oznaczWlasciwa(0)">OK</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div id="inneOdpowiedzi"></div>
                <input type="hidden" name="ileOdpowiedzi" value="1" id="ileOdpowiedzi"/>
                <input type="hidden" name="odpowiedzi" value="" id="odpowiedzi"/>
                <input type="hidden" name="wlasciwa" value="" id="wlasciwa"/>
                <br /><br />
                <a id="zapisz" class="btn btn-dark">ZAPISZ</a>
            </form>
        </div>
    </div>
    <script src="/ad/rataqPL.js"></script>
@endsection