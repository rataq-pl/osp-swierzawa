@extends('admin.theme')
@section('tresci')
<div class="starter-template" style="display: flex; flex-wrap: wrap; justify-content: center;">
    <div class="col-12">
        <div class="col-12 d-flex pb-3" style="justify-content: space-between;">
            <h3 class="title">Dodajesz sponsora</h3>
            <a href="/admin/sponsorzy" class="btn btn-dark">Wstecz</a>
        </div>
        <form action="{{url()->current()}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-12 d-flex" style="justify-content: center; flex-wrap: wrap;">
                <div class="col-6 px-2 py-2">
                    <label class="col-12">Nazwa:</label>
                    <input name="nazwa" value="{{$sponsor->nazwa}}" type="text" class="form-control" placeholder="Wprowadź nazwę..."/>
                </div>
                <div class="col-6 px-2 py-2">
                    <label class="col-12">Zdjęcie:</label><br />
                    <input type="file" name="zdjecie" class="form-control"/><br />
                    <img src="{{asset($sponsor->zdjecie)}}" style="max-width: 150px;"/>
                </div>
                <div class="col-6 py-2">
                    <label class="col-12">Opis:</label>
                    <textarea name="opis" class="edytor" placeholder="Wprowadź opis...">{!! $sponsor->opis !!}</textarea>
                </div>
                <div class="col-6 py-2 d-flex" style="flex-wrap: wrap; justify-content: space-between; align-items: start;">
                    <div class="col-6 p-2">
                        <label class="col-12">WWW:</label>
                        <input name="www" value="{{$sponsor->www}}" type="text" class="form-control" placeholder="Wprowadź link fo strony www..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">Facebook:</label>
                        <input name="facebook" value="{{$sponsor->facebook}}" type="text" class="form-control" placeholder="Wprowadź link fo facebook.com..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">Instagram:</label>
                        <input name="instagram" value="{{$sponsor->instagram}}" type="text" class="form-control" placeholder="Wprowadź link do instagram.com..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">TikTok:</label>
                        <input name="tiktok" value="{{$sponsor->tiktok}}" type="text" class="form-control" placeholder="Wprowadź link fo tiktok.com..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">Twitter:</label>
                        <input name="twitter" value="{{$sponsor->twitter}}" type="text" class="form-control" placeholder="Wprowadź link do twitter.com..."/>
                    </div>
                    <div class="col-6 p-2">
                        <label class="col-12">YouTube:</label>
                        <input name="youtube" value="{{$sponsor->youtube}}" type="text" class="form-control" placeholder="Wprowadź link do youtube.com..."/>
                    </div>
                </div>
                <button type="submit" class="col-12 btn btn-dark mt-5">Zapisz zmiany</button> 
            </div>
        </form>
    </div>
</div>
@endsection