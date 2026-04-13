@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    {!!$komunikat!!}
<div class="table-responsive">    
    <table class="table table-striped table-sm">
        <a href="/admin/kursy/pytania/dodaj/{{request()->segment(4)}}" class="btn btn-dark float-right">DODAJ PYTANIE</a>
        <h3>Wszystkie kursy</h3>
      <thead>
        <tr>
          <th>#</th>
          <th>Pytanie</th>
          <th>Opis</th>
          <th>Prawidłowa</th>
          <th>Zarządzaj</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pytania as $q)
            <tr>
                <td>{{$q -> id}}</td>
                <td>{{$q -> pytanie}}</td>
                <td>{!!$q -> wyjasnienie!!}</td>
                <td>{{$q -> prawidlowa}}</td>
                <td>
                    <a href="/admin/kursy/pytania/usun/{{$q -> id}}" class="btn btn-danger">USUŃ</a>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection