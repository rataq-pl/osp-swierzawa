@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    <div class="col-md-8 offset-2" style="text-align:left;">
        {!!$komunikat!!}
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <label>Tytuł:</label>
            <input type="text" value="{{$q -> tytul}}" name="tytul" class="form-control" placeholder="Wprowadź tytuł..."/>
            <br /><br />
            <label>Kategoria</label>
            <select name="kategoria" class="form-control">
                @php
                    if($q -> kategoria == 'Zdarzenia'){
                        $a = 'selected';
                        $b = '';
                        $c = '';
                    }elseif($q -> kategoria == 'Kampanie'){
                        $a = '';
                        $b = 'selected';
                        $c = '';
                    }elseif($q -> kategoria == 'MDP'){
                        $a = '';
                        $b = '';
                        $c = 'selected';   
                    }else{
                        $a = '';
                        $b = '';
                        $c = '';
                    }
                @endphp
                <option value="#">Wybierz z listy</option>
                <option value="Zdarzenia" {{$a}}>Zdarzenia</option>
                <option value="MDP" {{$c}}>MDP</option>
                <option value="Kampanie" {{$b}}>Kampanie</option>
            </select><br /><br />
            <div class="col-md-12">
                <div class="col-md-8 float-left">
                    <label>URL:</label>
                    <input type="text" value="{{$q -> url}}" name="url" class="form-control" placeholder="Wprowadź URL..."/>
                    <br /><br />
                </div>
                <div class="col-md-4 float-left">
                    <label>Zdjęcie</label><br />
                    <img src="{{$q -> zdjecie}}" alt="" style="max-width:150px;"/><br />
                    <input type="hidden" name="zdjecieTeraz" value="{{$q -> zdjecie}}"/>
                    <input type="file" name="zdjecie"/>
                    <br /><br />
                </div>
            </div>
            <div class="clearfix"></div><br /><br /><br />
            <textarea name="tresc" class="edytor form-control" placeholder="Wprowadź treść...">{{$q -> tresc}}</textarea>
            <br /><br />
            <input type="submit" class="btn btn-dark" value="Dodaj"/>
        </form>
    </div>
</div>