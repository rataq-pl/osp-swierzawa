@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    {!!$komunikat!!}
<div class="table-responsive">    
    <table class="table table-striped table-sm">
        <a href="/admin/kursy/dodaj" class="btn btn-dark float-right">DODAJ</a>
        <h3>Wszystkie kursy</h3>
      <thead>
        <tr>
          <th>#</th>
          <th>Tytuł</th>
          <th>Opis</th>
          <th>Zdjęcie</th>
          <th>Zarządzaj</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($kursy as $q)
            <tr>
                <td>{{$q -> id}}</td>
                <td>{{$q -> tytul}}</td>
                <td>{{$q -> opis}}</td>
                <td><img src="{{$q -> zdjecie}}" alt="" style="max-width:100px;"/></td>
                <td>
                    <a href="/admin/kursy/pytania/{{$q -> id}}" class="btn btn-primary">PYTANIA</a>
                    <a href="/admin/kursy/edytuj/{{$q -> id}}" class="btn btn-success">EDYTUJ</a>
                    <a href="/admin/kursy/usun/{{$q -> id}}" class="btn btn-danger">USUŃ</a>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection