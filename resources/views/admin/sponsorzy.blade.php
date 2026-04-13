@extends('admin.theme')
@section('tresci')
<div class="starter-template" style="display: flex; flex-wrap: wrap; justify-content: center;">
    <div class="col-12">
        {!!$komunikat!!}
    </div>
    <div class="col-8">
        <div class="col-12 d-flex pb-3" style="justify-content: space-between;">
            <h3 class="title">Lista sponsorów</h3>
            <a href="/admin/sponsorzy/dodaj" class="btn btn-dark">Dodaj nowego</a>
        </div>
        <table class="table table-striped table-sm">
            <thead>
                <th>Nazwa</th>
                <th>Grafika</th>
                <th>Opis</th>
                <th>Zarządzaj</th>
            </thead>
            <tbody>
                @foreach($sponsorzy as $sponsor)
                    <tr>
                        <td>{{$sponsor -> nazwa}}</td>
                        <td><img src="{{asset($sponsor -> zdjecie)}}" style="max-width: 150px;"/></td>
                        <td>{{ Str::limit(strip_tags($sponsor -> opis), 150)}}</td>
                        <td class="d-flex" style="flex-wrap: wrap; align-items: center;">
                            <a href="/admin/sponsorzy/edycja/{{$sponsor->id}}" class="btn btn-dark mt-0">Edycja</a>
                            <form method="POST" action="/admin/sponsorzy/usun/{{$sponsor->id}}" class="mb-0 ml-2">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Na pewno usunąć?');">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>