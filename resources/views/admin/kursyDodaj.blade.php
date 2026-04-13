@extends('admin.theme')
@section('tresci')
    <div class="starter-template">
        {!!$komunikat!!}
        <div class="col-md-4 offset-4">
            <form method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <label>Tytuł:</label>
                <input type="text" name="tytul" class="form-control" placeholder="Wprowadź tytuł (np. Pierwsza pomoc)..."/>
                <label>Zdjęcie:</label><br />
                <input type="file" name="zdjecie"/><br />
                <label>URL:</label>
                <input type="text" name="url" class="form-control" placeholder="Wprowadź URL (np. pierwsza-pomoc)..."/>
                <label>Opis:</label>
                <input type="text" name="opis" class="form-control" placeholder="Wprowadź opis..."/>
                <br /><br />
                <input type="submit" class="btn btn-dark" value="Zapisz"/>
            </form>
        </div>
    </div>
@endsection