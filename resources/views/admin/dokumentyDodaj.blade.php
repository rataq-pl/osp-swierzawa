@extends('admin.theme')
@section('tresci')
    <div class="starter-template">
        <div class="col-md-8 offset-2">
            <form method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <label>Nazwa</label>
                <input type="text" name="nazwa" class="form-control" placeholder="Wprowadź nazwę dla dokumentów..."/><br /><br />
                <label>Dokumenty</label><br />
                <input type="file" name="dokumenty[]" multiple/><br /><br />
                <label>Opis dokumentów:</label><br />
                <textarea name="opis" class="form-control" placeholder="Wprowadź opis mówiący o udostępnianych dokumentach..."></textarea>
                <input type="submit" class="btn btn-dark float-right" value="Dodaj" style="margin-top:5%;"/>
            </form>
        </div>
    </div>
@endsection