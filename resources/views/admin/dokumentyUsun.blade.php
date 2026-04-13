@extends('admin.theme')
@section('tresci')
    <div class="starter-template">
        <div class="col-md-4 offset-4">
            <form method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <input type="submit" class="btn btn-danger" value="Potwierdź usunięcie"/>
            </form>
        </div>
    </div>
@endsection