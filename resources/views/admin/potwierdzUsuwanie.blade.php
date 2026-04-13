@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    <form method="POST">
        @csrf
        <input type="submit" class="btn btn-danger" value="Potwierdź usunięcie"/>
    </form>
</div>
@endsection