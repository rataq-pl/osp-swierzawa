@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    <div class="col-md-8 offset-2" style="text-align:left;">
        {!!$komunikat!!}
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <label>Tytuł:</label>
            <input type="text" name="tytul" class="form-control" placeholder="Wprowadź tytuł..."/>
            <br /><br />
            <label>Kategoria</label>
            <select name="kategoria" class="form-control">
                <option value="#">Wybierz z listy</option>
                <option value="Zdarzenia">Zdarzenia</option>
                <option value="MDP">MDP</option>
                <option value="Kampanie">Kampanie</option>
            </select><br /><br />
            <div class="col-md-12">
                <div class="col-md-8 float-left">
                    <label>URL:</label>
                    <input type="text" name="url" class="form-control" placeholder="Wprowadź URL..."/>
                    <br /><br />
                </div>
                <div class="col-md-4 float-left">
                    <label>Zdjęcie</label><br />
                    <input type="file" name="zdjecia[]" multiple/>
                    <br /><br />
                </div>
            </div>
            <div class="clearfix"></div><br /><br /><br />
            <textarea name="tresc" class="edytor form-control" placeholder="Wprowadź treść..."></textarea>
            <br /><br />
            <input type="submit" class="btn btn-dark" value="Dodaj"/>
        </form>
    </div>
</div>