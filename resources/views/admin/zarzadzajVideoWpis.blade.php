@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    {!!$info!!}
    <div class="table-responsive">    
        <h3 class="title">Dodajesz nowe video do <code>{{$wpis -> tytul}}</code></h3>
        <div class="col-12">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <label>Wybierz plik</label>
                <input type="file" name="video"/>
                <input type="submit" class="btn btn-dark" value="Dodaj materiał"/>
            </form>
        </div>
        <div class="col-12 d-flex flex-wrap justify-content-center align-items-center align-content-center p-5">
            @foreach ($video as $q)
                <div class="col-6">
                    <video class="col-12" controls>
                        <source src="{{asset($q -> url)}}" type="video/mp4">
                    </video>
                    <a href="/admin/usunVideo/{{$q -> id}}" class="btn btn-danger">Usuń</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection