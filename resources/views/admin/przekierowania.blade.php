@extends('admin.theme')
@section('tresci')
<div class="starter-template" style="display: flex; flex-wrap: wrap; justify-content: center;">
    <div class="col-12">
        {!!$komunikat!!}
    </div>
    <div class="col-10">
        <div class="col-12 d-flex pb-3" style="justify-content: space-between;">
            <h3 class="title">Przekierowania poczty {{$skrzynka}}</h3>
        </div>
        <p class="text-muted">
            Co minutę nowe wiadomości ze skrzynki {{$skrzynka}} są sprawdzane pod kątem aliasu, przez który trafiły
            (np. <code>dominika33@osp-swierzawa.pl</code>). Wzorzec <code>dominika*</code> lub sam początek <code>dominika</code>
            pasuje do wszystkich aliasów zaczynających się od „dominika”. Gdy pasuje kilka reguł, wygrywa dłuższy (bardziej szczegółowy) wzorzec.
            Wiadomości bez pasującej reguły zostają w skrzynce, oznaczone jako przeczytane.
        </p>

        <form action="/admin/przekierowania" method="post" class="mb-4">
            @csrf
            @if($edycja)
                <input type="hidden" name="id" value="{{$edycja->id}}"/>
            @endif
            <div class="d-flex" style="flex-wrap: wrap; align-items: end;">
                <div class="col-3 px-2 py-2">
                    <label>Alias (początek / wzorzec):</label>
                    <input name="alias" type="text" class="form-control" placeholder="np. dominika*" value="{{old('alias', $edycja->alias ?? '')}}" required/>
                </div>
                <div class="col-4 px-2 py-2">
                    <label>Przekieruj na (kilka adresów po przecinku):</label>
                    <input name="email" type="text" class="form-control" placeholder="np. jan@example.com" value="{{old('email', $edycja->email ?? '')}}" required/>
                </div>
                <div class="col-3 px-2 py-2">
                    <label>Opis:</label>
                    <input name="opis" type="text" class="form-control" placeholder="opcjonalnie" value="{{old('opis', $edycja->opis ?? '')}}"/>
                </div>
                <div class="col-2 px-2 py-2">
                    <label class="d-block"><input type="checkbox" name="aktywne" value="1" {{($edycja->aktywne ?? 1) ? 'checked' : ''}}/> Aktywne</label>
                    <button type="submit" class="btn btn-dark btn-block">{{$edycja ? 'Zapisz' : 'Dodaj regułę'}}</button>
                    @if($edycja)
                        <a href="/admin/przekierowania" class="btn btn-secondary btn-block mt-1">Anuluj</a>
                    @endif
                </div>
            </div>
            @if($errors->any())
                <div class="alert alert-danger mx-2">{{ $errors->first() }}</div>
            @endif
        </form>

        <table class="table table-striped table-sm">
            <thead>
                <th>Alias</th>
                <th>Przekieruj na</th>
                <th>Opis</th>
                <th>Status</th>
                <th>Zarządzaj</th>
            </thead>
            <tbody>
                @forelse($reguly as $r)
                    <tr>
                        <td><code>{{$r->alias}}</code></td>
                        <td>{{$r->email}}</td>
                        <td>{{$r->opis}}</td>
                        <td>{!! $r->aktywne ? '<span class="badge badge-success">aktywna</span>' : '<span class="badge badge-secondary">wyłączona</span>' !!}</td>
                        <td class="d-flex" style="flex-wrap: wrap; align-items: center;">
                            <a href="/admin/przekierowania?edytuj={{$r->id}}" class="btn btn-dark btn-sm mt-0">Edycja</a>
                            <form method="POST" action="/admin/przekierowania/usun/{{$r->id}}" class="mb-0 ml-2">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Na pewno usunąć?');">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Brak reguł</td></tr>
                @endforelse
            </tbody>
        </table>

        <h4 class="title mt-5" id="historia">Ostatnio sprawdzone wiadomości</h4>
        <div class="d-flex mb-3" style="flex-wrap: wrap;">
            <div class="col-3 px-1"><div class="alert alert-success text-center mb-0"><h3 class="mb-0">{{$licznik['przekierowano']}}</h3>przekierowanych</div></div>
            <div class="col-3 px-1"><div class="alert alert-info text-center mb-0"><h3 class="mb-0">{{$licznik['dzisiaj']}}</h3>przekierowanych dzisiaj</div></div>
            <div class="col-3 px-1"><div class="alert alert-secondary text-center mb-0"><h3 class="mb-0">{{$licznik['brak_reguly']}}</h3>bez przekierowania</div></div>
            <div class="col-3 px-1"><div class="alert alert-danger text-center mb-0"><h3 class="mb-0">{{$licznik['blad']}}</h3>błędów wysyłki</div></div>
        </div>
        <table class="table table-striped table-sm" style="font-size: 0.9em;">
            <thead>
                <th>Data</th>
                <th>Od</th>
                <th>Temat</th>
                <th>Alias</th>
                <th>Wynik</th>
            </thead>
            <tbody>
                @forelse($log as $l)
                    <tr>
                        <td style="white-space: nowrap;">{{$l->created_at}}</td>
                        <td>{{$l->nadawca}}</td>
                        <td>{{ Str::limit($l->temat, 80) }}</td>
                        <td>{{$l->alias}}</td>
                        <td>
                            @switch($l->status)
                                @case('przekierowano') <span class="badge badge-success">przekierowano</span> → {{$l->email}} @break
                                @case('brak_reguly') <span class="badge badge-secondary">bez przekierowania</span> @break
                                @case('pominieto') <span class="badge badge-info">pominięto (już przekierowana)</span> @break
                                @default <span class="badge badge-danger">błąd</span> {{$l->blad}}
                            @endswitch
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Brak wpisów</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Wpisy {{$log->firstItem() ?? 0}}–{{$log->lastItem() ?? 0}} z {{$log->total()}}</small>
            {{ $log->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
