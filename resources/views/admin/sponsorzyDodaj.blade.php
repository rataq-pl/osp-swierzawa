@extends('admin.theme')
@section('tresci')
<div class="starter-template" style="display: flex; flex-wrap: wrap; justify-content: center;">
    <div class="col-12">
    {!!$komunikat!!}
    </div>
    <div class="col-12">
        <div class="col-12 d-flex pb-3" style="justify-content: space-between;">
            <h3 class="title">Dodajesz sponsora</h3>
            <a href="/admin/sponsorzy" class="btn btn-dark">Wstecz</a>
        </div>
        <form action="/admin/sponsorzy/dodaj" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-12 d-flex" style="justify-content: center; flex-wrap: wrap;">
                <div class="col-6 px-2 py-2">
                    <label class="col-12">Nazwa:</label>
                    <input name="nazwa" type="text" class="form-control" placeholder="Wprowadź nazwę..."/>
                </div>
                <div class="col-6 px-2 py-2">
                    <label class="col-12">Zdjęcie:</label>
                    <input type="file" name="zdjecie" class="form-control"/>
                </div>
                <div class="col-6 py-2">
                    <label class="col-12">Opis:</label>
                    <textarea name="opis" class="edytor" placeholder="Wprowadź opis..."></textarea>
                </div>
                <div class="col-6 py-2 d-flex" style="flex-wrap: wrap; justify-content: space-between; align-items: start;">
                    <div class="col-6 p-2">
                        <label class="col-12">WWW:</label>
                        <input name="www" type="text" class="form-control" placeholder="Wprowadź link fo strony www..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">Facebook:</label>
                        <input name="facebook" type="text" class="form-control" placeholder="Wprowadź link fo facebook.com..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">Instagram:</label>
                        <input name="instagram" type="text" class="form-control" placeholder="Wprowadź link do instagram.com..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">TikTok:</label>
                        <input name="tiktok" type="text" class="form-control" placeholder="Wprowadź link fo tiktok.com..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">Twitter:</label>
                        <input name="twitter" type="text" class="form-control" placeholder="Wprowadź link do twitter.com..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">YouTube:</label>
                        <input name="youtube" type="text" class="form-control" placeholder="Wprowadź link do youtube.com..."/>
                    </div>
                </div>
                <button type="submit" class="col-12 btn btn-dark mt-5">Dodaj sponsora</button> 
            </div>
        </form>
    </div>
</div>
@endsection