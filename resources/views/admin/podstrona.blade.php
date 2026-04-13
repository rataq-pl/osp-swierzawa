@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    {!!$komunikat!!}
    <div class="table-responsive text-left">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <label>Tytuł:</label>
            <input type="text" name="tytul" class="form-control" placeholder="Wprowadź tytuł..." value="{{$q -> tytul}}"/><br /><br />
            <label>Zdjęcie:</label><br /><br />
            <input type="hidden" name="zdjecieTeraz" value="{{$q -> zdjecie}}"/>
            <img src="{{$q -> zdjecie}}" alt="" style="max-width:200px;"/><br /><br />
            <input type="file" name="zdjecie"/><br /><br /><br /><br />
            <label>Treść</label>
            <textarea name="tresc" class="edytor" placeholder="Wprowadź treść...">{{$q -> tresc}}</textarea><br /><br /><br />
            <input type="submit" class="btn btn-dark float-right" value="Zapisz zmiany"/>
        </form>
    </div>
</div>
@endsection