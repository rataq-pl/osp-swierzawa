@extends('admin.theme')
@section('tresci')
<div class="starter-template" style="display: flex; flex-wrap: wrap; justify-content: center;">
    <div class="col-12">
        {!!$komunikat!!}
    </div>

    @if($newToken)
    <div class="col-12">
        <div class="alert alert-warning">
            <h5>Twoj nowy token API:</h5>
            <code style="word-break: break-all; font-size: 14px; background: #333; color: #0f0; padding: 10px; display: block; border-radius: 5px;">{{$newToken}}</code>
            <p class="mt-2 mb-0"><strong>Uwaga:</strong> Skopiuj ten token teraz. Nie bedzie mozna go ponownie wyswietlic!</p>
        </div>
    </div>
    @endif

    <div class="col-12 col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Twoje dane</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Nazwa:</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th>E-mail:</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th>Imie i nazwisko:</th>
                        <td>{{$user->imie}} {{$user->nazwisko}}</td>
                    </tr>
                    <tr>
                        <th>Rola:</th>
                        <td>
                            @if($user->role === 'super_admin')
                                <span class="badge badge-danger">Super Administrator</span>
                            @else
                                <span class="badge badge-secondary">Administrator</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Generuj nowy token API</h5>
            </div>
            <div class="card-body">
                <form action="/admin/profile/token" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nazwa tokenu:</label>
                        <input type="text" name="token_name" class="form-control" placeholder="np. Integracja zewnetrzna" required/>
                    </div>
                    <div class="form-group">
                        <label>Uprawnienia:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="abilities[]" value="blog:read" id="ability_read">
                            <label class="form-check-label" for="ability_read">blog:read - odczyt wpisow</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="abilities[]" value="blog:create" id="ability_create">
                            <label class="form-check-label" for="ability_create">blog:create - tworzenie wpisow</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="abilities[]" value="blog:update" id="ability_update">
                            <label class="form-check-label" for="ability_update">blog:update - edycja wpisow</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="abilities[]" value="blog:delete" id="ability_delete">
                            <label class="form-check-label" for="ability_delete">blog:delete - usuwanie wpisow</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="abilities[]" value="*" id="ability_all">
                            <label class="form-check-label" for="ability_all">* - pelne uprawnienia</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark">Generuj token</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Twoje tokeny API</h5>
            </div>
            <div class="card-body">
                @if(count($tokens) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nazwa</th>
                                <th>Uprawnienia</th>
                                <th>Ostatnie uzycie</th>
                                <th>Utworzono</th>
                                <th>Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokens as $token)
                            <tr>
                                <td>{{$token->name}}</td>
                                <td>
                                    @php
                                        $abilities = json_decode($token->abilities, true) ?? [];
                                    @endphp
                                    @foreach($abilities as $ability)
                                        <span class="badge badge-info">{{$ability}}</span>
                                    @endforeach
                                </td>
                                <td>{{$token->last_used_at ?? 'Nigdy'}}</td>
                                <td>{{$token->created_at}}</td>
                                <td>
                                    <form action="/admin/profile/token/revoke/{{$token->id}}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Na pewno usunac ten token?');">Usun</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0">Nie masz jeszcze zadnych tokenow API.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Dokumentacja API</h5>
            </div>
            <div class="card-body">
                <p>Endpointy API dostepne pod adresem: <code>{{url('/api/v1')}}</code></p>
                <h6>Przykladowe uzycie:</h6>
                <pre style="background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto;">
# Health check (publiczny)
curl {{url('/api/v1/ping')}}

# Lista wpisow (wymaga tokenu z blog:read)
curl -H "Authorization: Bearer TWOJ_TOKEN" {{url('/api/v1/blog')}}

# Nowy wpis (wymaga tokenu z blog:create)
curl -X POST {{url('/api/v1/blog')}} \
  -H "Authorization: Bearer TWOJ_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"tytul":"Tytul","tresc":"&lt;p&gt;Tresc&lt;/p&gt;"}'
                </pre>
                <p class="mt-2">Pelna dokumentacja: <a href="/API_PUBLISHER.md" target="_blank">API_PUBLISHER.md</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
