@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    {!!$komunikat!!}
<div class="table-responsive">    
    <h3>Zarządzasz galerią wpisu {{$wpis -> tytul}}</h3>
    <div class="col-md-12 text-center" style="margin-bottom:15%; margin-top:5%;">
        <form method="POST" enctype="multipart/form-data">
            @csrf   
            <div class="col-md-3 offset-3" style="display:block; float:left;">
                <input type="file" name="zdjecia[]" multiple/>
            </div>
            <div class="col-md-3" style="display:block; float:left;">
                <input type="submit" class="btn btn-dark"/>
            </div>
        </form>
    </div>
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Zdjęcie</th>
          <th>Tytuł</th>
          <th>Zarządzaj</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($zdjecia as $q)
            <tr>
                <td>{{$q -> id}}</td>
                <td><img src="{{$q -> url}}" style="max-width:200px;"/></td>
                <td>{{$q -> tytul}}</td>
                <td><a href="/admin/galeria/usunFote/{{$q -> id}}" class="btn btn-danger">Usuń</a></td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
</div>
@endsection