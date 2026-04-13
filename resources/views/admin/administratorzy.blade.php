@extends('admin.theme')
@section('tresci')
<div class="starter-template" style="display: flex; flex-wrap: wrap; justify-content: center;">
    <div class="col-12">
        {!!$komunikat!!}
    </div>
    <div class="col-10">
        <div class="col-12 d-flex pb-3" style="justify-content: space-between;">
            <h3 class="title">Lista administratorow</h3>
            <a href="/admin/administratorzy/dodaj" class="btn btn-dark">Dodaj nowego</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nazwa</th>
                        <th>E-mail</th>
                        <th>Imie i nazwisko</th>
                        <th>Rola</th>
                        <th>Utworzono</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($administratorzy as $admin)
                        <tr>
                            <td>{{$admin->id}}</td>
                            <td>{{$admin->name}}</td>
                            <td>{{$admin->email}}</td>
                            <td>{{$admin->imie}} {{$admin->nazwisko}}</td>
                            <td>
                                @if($admin->role === 'super_admin')
                                    <span class="badge badge-danger">Super Admin</span>
                                @else
                                    <span class="badge badge-secondary">Admin</span>
                                @endif
                            </td>
                            <td>{{$admin->created_at}}</td>
                            <td>
                                @if($admin->role !== 'super_admin' && $admin->email !== 'mateusz@rataq.pl' && strtolower($admin->name) !== 'rataq')
                                    <form method="POST" action="/admin/administratorzy/usun/{{$admin->id}}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Na pewno usunac tego administratora?');">Usun</button>
                                    </form>
                                @else
                                    <span class="text-muted">Chroniony</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
