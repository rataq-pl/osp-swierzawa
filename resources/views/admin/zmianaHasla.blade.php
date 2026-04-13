@extends('admin.theme')
@section('tresci')
    <div class="starter-template">
        <div class="col-md-4 offset-4">
            <form method="POST">
                @csrf
                <label>Nowe hasło</label>
                <input type="password" name="haslo1" class="form-control" placeholder="Wprowadź hasło..."/>
                <br /><br />
                <label>Powtórz hasło</label>
                <input type="password" name="haslo2" class="form-control" style="margin-bottom:5%;" placeholder="Powtórz hasło..."/>
                <input type="submit" class="btn btn-dark" value="Zapisz zmiany"/>
            </form>
        </div>
    </div>
@endsection