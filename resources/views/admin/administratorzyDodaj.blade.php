@extends('admin.theme')
@section('tresci')
<div class="starter-template" style="display: flex; flex-wrap: wrap; justify-content: center;">
    <div class="col-12">
        {!!$komunikat!!}
    </div>
    <div class="col-8">
        <div class="col-12 d-flex pb-3" style="justify-content: space-between;">
            <h3 class="title">Dodaj administratora</h3>
            <a href="/admin/administratorzy" class="btn btn-dark">Wstecz</a>
        </div>
        <form action="/admin/administratorzy/dodaj" method="post">
            @csrf
            <div class="row">
                <div class="col-6 py-2">
                    <label>Nazwa uzytkownika:</label>
                    <input name="name" type="text" class="form-control" placeholder="Login..." required/>
                </div>
                <div class="col-6 py-2">
                    <label>E-mail:</label>
                    <input name="email" type="email" class="form-control" placeholder="E-mail..." required/>
                </div>
                <div class="col-6 py-2">
                    <label>Haslo:</label>
                    <input name="password" type="password" class="form-control" placeholder="Haslo..." required/>
                </div>
                <div class="col-6 py-2">
                    <label>Rola:</label>
                    <select name="role" class="form-control">
                        <option value="admin">Administrator</option>
                        <option value="super_admin">Super Administrator</option>
                    </select>
                </div>
                <div class="col-6 py-2">
                    <label>Imie:</label>
                    <input name="imie" type="text" class="form-control" placeholder="Imie..."/>
                </div>
                <div class="col-6 py-2">
                    <label>Nazwisko:</label>
                    <input name="nazwisko" type="text" class="form-control" placeholder="Nazwisko..."/>
                </div>
                <div class="col-12 py-3">
                    <button type="submit" class="btn btn-dark btn-block">Dodaj administratora</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
