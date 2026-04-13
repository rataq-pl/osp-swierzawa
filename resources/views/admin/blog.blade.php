@extends('admin.theme')
@section('tresci')
<div class="starter-template">
  {!!$komunikat!!}
  <div class="table-responsive">
      <table class="table table-striped table-sm">
          <a href="/admin/blog/dodaj" class="btn btn-dark float-right">DODAJ</a>
          <h3>Wszystkie wpisy</h3>
        <thead>
          <tr>
            <th>#</th>
            <th>Kategoria</th>
            <th style="width:15%">Tytuł</th>
            <th>Miniatura</th>
            <th>Wideo</th>
            <th>URL</th>
            <th>Zarządzaj</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($wpisy as $q)
              <tr>
                  <td>{{$q -> id}}</td>
                  <td>{{$q -> kategoria}}</td>
                  <td style="max-width:10%">{{$q -> tytul}}</td>
                  <td><img src="{{$q -> zdjecie}}" alt="" style="max-width:150px;"/></td>
                  <td><a href="/admin/blog/video/{{$q -> id}}" class="btn btn-dark" target="_blank">Zarządzaj</a></td>
                  <td><a href="/admin/galeria/{{$q -> id}}" class="btn btn-outline-danger">Galeria</a></td>
                  <td>
                      <a href="/admin/blog/edytuj/{{$q -> id}}" class="btn btn-success">EDYCJA</a>
                      <a href="/admin/blog/usun/{{$q -> id}}" class="btn btn-danger">USUŃ</a>
                  </td>
              </tr>
          @endforeach
        </tbody>
      </table>
  </div>
@endsection