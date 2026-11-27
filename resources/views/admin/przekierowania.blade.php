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

        <div class="d-flex mb-4" id="do-otwarcia" style="gap: 16px; flex-wrap: wrap; align-items: stretch;">
            <div class="card" style="flex: 1.2; min-width: 260px;">
                <form action="/admin/przekierowania/skrzynki" method="post" class="card-body py-3 mb-0" style="font-size: 0.9em;">
                    @csrf
                    <div class="text-muted mb-2">Ustawienia skrzynek (IMAP)</div>
                    <div class="d-flex mb-1" style="gap: 6px;">
                        <input name="host" class="form-control form-control-sm" placeholder="serwer" value="{{$skrzynkiHarnas['host']}}" required/>
                        <input name="port" type="number" class="form-control form-control-sm" style="max-width: 80px;" title="port IMAP SSL" value="{{$skrzynkiHarnas['port']}}" required/>
                    </div>
                    @foreach($skrzynkiHarnas['skrzynki'] as $i => $mail)
                        <input name="skrzynki[{{$i}}]" type="email" class="form-control form-control-sm mb-1" placeholder="skrzynka {{$i + 1}}" value="{{$mail}}" required/>
                    @endforeach
                    <input name="haslo" type="password" class="form-control form-control-sm mb-1" autocomplete="new-password"
                           placeholder="{{ $skrzynkiHarnas['haslo'] !== '' ? 'hasło zapisane - wpisz, aby zmienić' : 'hasło (wspólne dla obu)' }}"/>
                    <div class="d-flex" style="gap: 6px;">
                        <input name="nadawca" class="form-control form-control-sm" title="liczone są maile od tego nadawcy / domeny" value="{{$skrzynkiHarnas['nadawca']}}" required/>
                        <button type="submit" class="btn btn-dark btn-sm mt-0">Zapisz</button>
                    </div>
                </form>
            </div>
            @foreach($skrzynkiHarnas['skrzynki'] as $i => $mail)
                <div class="card text-center" data-skrzynka="{{$i}}" style="flex: 1; min-width: 220px;">
                    <div class="card-body py-3">
                        <div class="text-muted">{{$mail}} · do otwarcia</div>
                        <div class="licznik" style="font-size: 3em; font-weight: bold; line-height: 1.2;">…</div>
                        <div class="text-muted small opis">&nbsp;</div>
                        <div class="d-flex mt-2" style="gap: 6px; justify-content: center; flex-wrap: wrap;">
                            <input type="datetime-local" class="form-control form-control-sm granica" style="max-width: 190px; min-width: 0;"
                                   value="{{ now('Europe/Warsaw')->subDay()->format('Y-m-d\TH:i') }}" title="usuń wszystko odebrane przed tą datą i godziną"/>
                            <button type="button" class="btn btn-danger btn-sm mt-0 czysc" style="white-space: nowrap;">Czyść skrzynkę</button>
                        </div>
                        <div class="small mt-1 postep">&nbsp;</div>
                    </div>
                </div>
            @endforeach
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
                            <button type="button" class="btn btn-primary btn-sm mt-0 mr-2 maile" data-id="{{$r->id}}" data-alias="{{$r->alias}}">Maile</button>
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

        <h4 class="title mt-5" id="adresaci">Kto ile wiadomości otrzymał</h4>
        <p class="text-muted">
            Liczba wiadomości przekierowanych na każdy adres docelowy - czyli ile razy dana osoba zagłosowała.
            Wiadomość przekierowana na kilka adresów liczy się każdemu z nich. Kolumny dni wg czasu polskiego.
        </p>
        @if($adresaci['adresaci']->isEmpty())
            <div class="alert alert-secondary">Brak przekierowanych wiadomości.</div>
        @else
            <div class="table-responsive mb-4">
                <table class="table table-striped table-sm" style="font-size: 0.9em; white-space: nowrap;">
                    <thead>
                        <th>Adresat</th>
                        <th>Reguła / opis</th>
                        <th class="text-right">Łącznie</th>
                        @foreach($adresaci['daty'] as $data)
                            <th class="text-right">{{ \Carbon\Carbon::parse($data)->format('d.m') }}</th>
                        @endforeach
                        <th class="text-right">Aliasów</th>
                        <th>Ostatnia</th>
                    </thead>
                    <tbody>
                        @foreach($adresaci['adresaci'] as $a)
                            <tr>
                                <td>{{$a['adres']}}</td>
                                <td class="text-muted" style="white-space: normal;">{{$a['opis']}}</td>
                                <td class="text-right"><strong>{{$a['lacznie']}}</strong></td>
                                @foreach($adresaci['daty'] as $data)
                                    <td class="text-right {{ empty($a['dni'][$data]) ? 'text-muted' : '' }}">{{ $a['dni'][$data] ?? 0 }}</td>
                                @endforeach
                                <td class="text-right">{{$a['aliasy']}}</td>
                                <td>{{ $a['ostatnia']->format('d.m H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td colspan="2">Razem</td>
                            <td class="text-right">{{ $adresaci['adresaci']->sum('lacznie') }}</td>
                            @foreach($adresaci['daty'] as $data)
                                <td class="text-right">{{ $adresaci['adresaci']->sum(fn ($a) => $a['dni'][$data] ?? 0) }}</td>
                            @endforeach
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif

        <h4 class="title mt-5" id="konkurencja">Statystyka konkurencji</h4>
        <p class="text-muted">
            Przyrost głosów pierwszych 20 jednostek rankingu osp-harnas.pl w kolejnych dniach (odczyt co godzinę, ostatni o 23:55).
            Pogrubiony jest największy przyrost danego dnia. Gwiazdka (*) oznacza przyrost liczony od pierwszego odczytu tego dnia, bo brakuje odczytu z dnia poprzedniego.
            Kolumna „Ost. pomiar” to przyrost między dwoma ostatnimi odczytami
            @if($konkurencja['pomiar'])
                ({{ $konkurencja['pomiar']['od']->format('H:i') }} → {{ $konkurencja['pomiar']['do']->format('d.m H:i') }}).
            @else
                (pojawi się po drugim odczycie).
            @endif
        </p>
        @if(!$konkurencja['jednostki'])
            <div class="alert alert-secondary">Brak danych - pojawią się po pierwszym uruchomieniu <code>php artisan harnas:konkurencja</code>.</div>
        @else
            <div class="table-responsive mb-4">
                <table class="table table-striped table-sm" style="font-size: 0.9em; white-space: nowrap;">
                    <thead>
                        <th>#</th>
                        <th>Jednostka</th>
                        <th class="text-right">Głosy</th>
                        <th class="text-right" title="Przyrost od poprzedniego odczytu">Ost. pomiar</th>
                        <th class="text-right">7 dni</th>
                        @foreach($konkurencja['daty'] as $data)
                            <th class="text-right">{{ \Carbon\Carbon::parse($data)->format('d.m') }}</th>
                        @endforeach
                    </thead>
                    <tbody>
                        @foreach($konkurencja['jednostki'] as $j)
                            <tr @if($j['nasza']) class="table-warning" @endif>
                                <td>{{$j['pozycja'] ?? '-'}}</td>
                                <td>{{$j['nazwa']}}</td>
                                <td class="text-right">{{ $j['glosy'] !== null ? number_format($j['glosy'], 0, ',', ' ') : '-' }}</td>
                                <td class="text-right table-info">
                                    @if($j['ostatni'] === null)
                                        -
                                    @elseif($j['ostatni'] > 0 && $j['ostatni'] == $konkurencja['najwiecej']['ostatni'])
                                        <strong class="text-success">+{{$j['ostatni']}}</strong>
                                    @else
                                        +{{$j['ostatni']}}
                                    @endif
                                </td>
                                <td class="text-right"><strong>+{{ number_format($j['tydzien'], 0, ',', ' ') }}</strong></td>
                                @foreach($konkurencja['daty'] as $data)
                                    @php($p = $j['przyrosty'][$data] ?? null)
                                    <td class="text-right {{ $p && $p['czesciowy'] ? 'text-muted' : '' }}">
                                        @if($p)
                                            @if($p['glosy'] > 0 && $p['glosy'] == $konkurencja['najwiecej'][$data])
                                                <strong class="text-success">+{{$p['glosy']}}</strong>
                                            @else
                                                +{{$p['glosy']}}
                                            @endif
                                            {{ $p['czesciowy'] ? '*' : '' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($konkurencja['wykres']['jednostki']->isNotEmpty())
            <h5 class="mt-4" id="konkurencja-wykres">Postępy jednostek</h5>
            <div class="d-flex mb-2" style="flex-wrap: wrap; align-items: center; gap: .5rem;">
                <div class="btn-group btn-group-sm" role="group" id="wykres-tryb">
                    <button type="button" class="btn btn-outline-primary" data-tryb="godzinowo">Godzinowo</button>
                    <button type="button" class="btn btn-outline-primary" data-tryb="dziennie">Dziennie</button>
                    <button type="button" class="btn btn-outline-primary" data-tryb="tygodniowo">Tygodniowo</button>
                </div>
                <div class="btn-group btn-group-sm" role="group" id="wykres-zakres"></div>
                <small class="text-muted">Zaznacz jednostki do porównania (najwyżej 8 naraz). Domyślnie pierwsze 3 miejsca.</small>
            </div>
            <div id="wykres-jednostki" class="mb-3" style="column-width: 16rem; font-size: 0.9em;"></div>
            <div id="wykres-brak" class="alert alert-secondary d-none"></div>
            <div class="row" id="wykres-wykresy">
                <div class="col-lg-6 mb-3">
                    <div class="small font-weight-bold mb-1">Łączna liczba głosów</div>
                    <div style="position: relative; height: 320px;"><canvas id="wykres-glosy"></canvas></div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="small font-weight-bold mb-1" id="wykres-przyrost-tytul">Przyrost</div>
                    <div style="position: relative; height: 320px;"><canvas id="wykres-przyrost"></canvas></div>
                </div>
            </div>
        @endif

        <h4 class="title mt-5" id="historia">Ostatnio sprawdzone wiadomości</h4>
        <div class="d-flex mb-3" style="flex-wrap: wrap;">
            <div class="col-3 px-1"><div class="alert alert-success text-center mb-0"><h3 class="mb-0">{{$licznik['przekierowano']}}</h3>przekierowanych</div></div>
            <div class="col-3 px-1"><div class="alert alert-info text-center mb-0"><h3 class="mb-0">{{$licznik['dzisiaj']}}</h3>przekierowanych dzisiaj</div></div>
            <div class="col-3 px-1">
                <a href="#" data-toggle="modal" data-target="#bezPrzekierowania" class="alert alert-secondary text-center mb-0 d-block text-reset" style="text-decoration: none;" title="Pokaż wiadomości bez przekierowania">
                    <h3 class="mb-0">{{$licznik['brak_reguly']}}</h3>bez przekierowania <small>(pokaż)</small>
                </a>
            </div>
            <div class="col-3 px-1"><div class="alert alert-danger text-center mb-0"><h3 class="mb-0">{{$licznik['blad']}}</h3>błędów wysyłki</div></div>
        </div>
        <table class="table table-striped table-sm" style="font-size: 0.9em;">
            <thead>
                <th>Data</th>
                <th>Od</th>
                <th>Temat</th>
                <th>Alias</th>
                <th>Wynik</th>
                <th></th>
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
                            @if($l->potwierdzono_at)
                                <span class="badge badge-primary">potwierdzono</span>
                            @endif
                        </td>
                        <td><button type="button" class="btn btn-outline-dark btn-sm py-0 podglad" data-id="{{$l->id}}">podgląd</button></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Brak wpisów</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Wpisy {{$log->firstItem() ?? 0}}–{{$log->lastItem() ?? 0}} z {{$log->total()}}</small>
            {{ $log->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<div class="modal fade" id="bezPrzekierowania" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Wiadomości bez przekierowania
                    <small class="text-muted">
                        @if($licznik['brak_reguly'] > $bezPrzekierowania->count())
                            (ostatnie {{$bezPrzekierowania->count()}} z {{$licznik['brak_reguly']}})
                        @else
                            ({{$bezPrzekierowania->count()}})
                        @endif
                    </small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zamknij"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body d-flex p-0" style="height: 75vh;">
                <div class="list-group list-group-flush border-right" style="width: 35%; overflow-y: auto;">
                    @forelse($bezPrzekierowania as $b)
                        <a href="#" class="list-group-item list-group-item-action podglad py-2" data-id="{{$b->id}}">
                            <div class="d-flex justify-content-between">
                                <strong class="text-truncate">{{ $b->temat ?: '(bez tematu)' }}</strong>
                                <small class="text-muted ml-2" style="white-space: nowrap;">{{ \Carbon\Carbon::parse($b->created_at)->format('d.m H:i') }}</small>
                            </div>
                            <small class="d-block text-truncate">{{$b->nadawca}}</small>
                            <small class="d-block text-muted text-truncate">alias: {{ $b->alias ?: '-' }}</small>
                        </a>
                    @empty
                        <div class="p-3 text-muted">Brak wiadomości bez przekierowania</div>
                    @endforelse
                </div>
                <div class="d-flex flex-column" style="width: 65%;">
                    <div id="podglad-naglowki" class="p-3 border-bottom small d-none"></div>
                    <div id="podglad-stan" class="p-3 text-muted">Wybierz wiadomość z listy, aby zobaczyć jej treść (pobierana na bieżąco ze skrzynki {{$skrzynka}}).</div>
                    <iframe id="podglad-html" class="d-none flex-grow-1 border-0 w-100" sandbox="allow-popups allow-popups-to-escape-sandbox"></iframe>
                    <pre id="podglad-tekst" class="d-none flex-grow-1 p-3 mb-0" style="white-space: pre-wrap; overflow-y: auto;"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="maile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Maile reguły <code id="maile-regula"></code></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zamknij"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small">
                    Ostatnie wiadomości z aliasów pasujących do reguły, pobierane na bieżąco ze skrzynki {{$skrzynka}}.
                    „Potwierdź” otwiera link z treści maila w nowej karcie i zapisuje, że wiadomość została potwierdzona.
                </p>
                <div id="maile-stan" class="text-muted"></div>
                <table class="table table-sm d-none" id="maile-tabela" style="font-size: 0.9em;">
                    <thead>
                        <th>Data</th>
                        <th>Alias</th>
                        <th>Temat</th>
                        <th>Potwierdzenie</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="maile-odswiez">Odśwież</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('skrypty')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    // boksy "do otwarcia": dzisiejsze maile od nadawcy w skrzynkach harnas-potwierdzanie, odswiezane co 30 s
    $(function () {
        var trwaCzyszczenie = {};

        function odswiez() {
            $.getJSON('/admin/przekierowania/do-otwarcia').done(function (d) {
                d.skrzynki.forEach(function (s, i) {
                    var box = $('#do-otwarcia [data-skrzynka="' + i + '"]');
                    if (s.blad) {
                        box.find('.licznik').text('?').addClass('text-danger');
                        box.find('.opis').text('Błąd: ' + s.blad + ' · ' + d.czas);
                    } else {
                        box.find('.licznik').text(s.do_otwarcia).removeClass('text-danger');
                        box.find('.opis').text('wszystkich od nadawcy: ' + s.wszystkie + ' · ' + d.czas);
                    }
                });
            }).fail(function () {
                $('#do-otwarcia [data-skrzynka] .opis').text('Błąd odświeżania - ponowię za 30 s');
            });
        }
        odswiez();
        setInterval(odswiez, 30000);

        function blad(x) {
            var d = x.responseJSON || {};
            return d.blad || d.message || x.statusText || 'brak połączenia';
        }

        // "Czysc skrzynke": najpierw liczy maile do usuniecia, po potwierdzeniu usuwa partiami (kolejne krotkie
        // zadania az pozostalo = 0) - strona nie czeka na jedno dlugie zadanie i pokazuje postep
        $('#do-otwarcia .czysc').on('click', function () {
            var przycisk = $(this), box = przycisk.closest('[data-skrzynka]'), nr = box.data('skrzynka');
            var granica = box.find('.granica').val(), postep = box.find('.postep');
            var mail = box.find('.text-muted').first().text().split(' · ')[0];
            if (!granica || trwaCzyszczenie[nr]) {
                return;
            }
            var dane = {_token: '{{ csrf_token() }}', skrzynka: nr, granica: granica};
            przycisk.prop('disabled', true);
            postep.removeClass('text-danger text-success').text('Liczę maile do usunięcia…');

            $.post('/admin/przekierowania/czysc', $.extend({sucho: 1}, dane)).done(function (d) {
                if (!d.usunieto) {
                    postep.text('Brak maili odebranych przed ' + d.granica + '.');
                    przycisk.prop('disabled', false);
                    return;
                }
                if (!confirm('Trwale usunąć ze skrzynki ' + mail + ' ' + d.usunieto + ' maili odebranych przed ' + d.granica + '?\nTej operacji nie da się cofnąć.')) {
                    postep.html('&nbsp;');
                    przycisk.prop('disabled', false);
                    return;
                }
                var wszystkich = d.usunieto, usunieto = 0;
                trwaCzyszczenie[nr] = true;
                (function partia() {
                    $.post('/admin/przekierowania/czysc', dane).done(function (r) {
                        usunieto += r.usunieto;
                        postep.text('Usunięto ' + usunieto + ' z ' + Math.max(wszystkich, usunieto + r.pozostalo) + '…');
                        if (r.pozostalo > 0 && r.usunieto > 0) {
                            partia();
                            return;
                        }
                        trwaCzyszczenie[nr] = false;
                        przycisk.prop('disabled', false);
                        postep.addClass('text-success').text('Gotowe - usunięto ' + usunieto + ' maili sprzed ' + r.granica + '.');
                        odswiez();
                    }).fail(function (x) {
                        trwaCzyszczenie[nr] = false;
                        przycisk.prop('disabled', false);
                        postep.addClass('text-danger').text('Przerwano po ' + usunieto + ' maili: ' + blad(x) + ' - kliknij ponownie, aby dokończyć.');
                        odswiez();
                    });
                })();
            }).fail(function (x) {
                przycisk.prop('disabled', false);
                postep.addClass('text-danger').text('Błąd: ' + blad(x));
            });
        });
    });

    // wykres postepow konkurencji: glosy i przyrost (godzinowo / dziennie / tygodniowo) dla zaznaczonych jednostek
    $(function () {
        var dane = @json($konkurencja['wykres']);
        if (!dane.jednostki.length || !window.Chart) {
            return;
        }
        // kolor przypisany do jednostki na czas zaznaczenia - nie zmienia sie przy zmianie wyboru
        var KOLORY = ['#2a78d6', '#eb6834', '#1baf7a', '#eda100', '#e87ba4', '#008300', '#6250d6', '#e34948'];
        // zakresy: liczba ostatnich punktow (0 = wszystkie)
        var TRYBY = {
            godzinowo: {tytul: 'Przyrost na godzinę (między pomiarami)', zakresy: [['24 h', 24], ['3 dni', 72], ['7 dni', 0]], brak: 'Brak odczytów godzinowych - pojawią się po dwóch kolejnych uruchomieniach CRON-a.'},
            dziennie: {tytul: 'Przyrost dzienny', zakresy: [['7 dni', 7], ['14 dni', 14], ['30 dni', 30], ['Wszystko', 0]], brak: 'Brak danych dziennych.'},
            tygodniowo: {tytul: 'Przyrost tygodniowy', zakresy: [['8 tyg.', 8], ['Wszystko', 0]], brak: 'Brak danych tygodniowych.'}
        };
        var kolorJednostki = {};
        var tryb = dane.tryby.dziennie.etykiety.length ? 'dziennie' : 'godzinowo';
        var zakres = null;

        var lista = $('#wykres-jednostki');
        dane.jednostki.forEach(function (j, i) {
            var id = 'wj-' + i;
            lista.append($('<div class="custom-control custom-checkbox">').append(
                $('<input type="checkbox" class="custom-control-input">').attr('id', id).val(i).prop('checked', i < 3),
                $('<label class="custom-control-label">').attr('for', id).append(
                    $('<span class="wj-kolor d-inline-block mr-1">').css({width: 10, height: 10, borderRadius: 2, verticalAlign: 'middle'}),
                    document.createTextNode((j.pozycja ? j.pozycja + '. ' : '') + j.nazwa),
                    j.nasza ? $('<strong>').text(' (my)') : null
                )
            ));
        });

        function opcje(przyrost) {
            return {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                interaction: {mode: 'index', intersect: false},
                plugins: {
                    legend: {position: 'bottom', labels: {boxWidth: 12, color: '#52514e'}},
                    tooltip: {
                        itemSort: function (a, b) { return (b.parsed.y || 0) - (a.parsed.y || 0); },
                        callbacks: {
                            label: function (c) {
                                var v = c.parsed.y;
                                return c.dataset.label + ': ' + (przyrost && v > 0 ? '+' : '') + v.toLocaleString('pl-PL');
                            }
                        }
                    }
                },
                scales: {
                    x: {grid: {display: false}, ticks: {color: '#52514e', maxRotation: 0, autoSkipPadding: 12}},
                    y: {beginAtZero: przyrost, grid: {color: '#ecebe8'}, ticks: {color: '#52514e', precision: 0}}
                }
            };
        }

        var wykresGlosy = new Chart(document.getElementById('wykres-glosy'), {type: 'line', data: {labels: [], datasets: []}, options: opcje(false)});
        var wykresPrzyrost = new Chart(document.getElementById('wykres-przyrost'), {type: 'line', data: {labels: [], datasets: []}, options: opcje(true)});

        function zbiorDanych(nazwa, wartosci, kolor, punkty) {
            return {
                label: nazwa, data: wartosci, borderColor: kolor, backgroundColor: kolor,
                borderWidth: 2, pointRadius: punkty ? 3 : 0, pointHoverRadius: 5, tension: 0, spanGaps: false
            };
        }

        function ustawTryb(nowy) {
            tryb = nowy;
            zakres = TRYBY[tryb].zakresy[0][1];
            $('#wykres-tryb button').removeClass('active').filter('[data-tryb="' + tryb + '"]').addClass('active');
            $('#wykres-zakres').empty().append(TRYBY[tryb].zakresy.map(function (z, i) {
                return $('<button type="button" class="btn btn-outline-secondary">').toggleClass('active', i === 0).data('zakres', z[1]).text(z[0]);
            }));
            $('#wykres-przyrost-tytul').text(TRYBY[tryb].tytul);
            rysuj();
        }

        function rysuj() {
            var zaznaczone = lista.find('input:checked').map(function () { return +this.value; }).get();
            // zwalniamy kolory odznaczonych, nowo zaznaczonym dajemy pierwszy wolny
            Object.keys(kolorJednostki).forEach(function (i) {
                if (zaznaczone.indexOf(+i) < 0) {
                    delete kolorJednostki[i];
                }
            });
            zaznaczone.forEach(function (i) {
                if (!kolorJednostki[i]) {
                    var zajete = Object.values(kolorJednostki);
                    kolorJednostki[i] = KOLORY.find(function (k) { return zajete.indexOf(k) < 0; });
                }
            });
            lista.find('input').each(function () {
                var k = kolorJednostki[+this.value];
                $(this).prop('disabled', !this.checked && zaznaczone.length >= KOLORY.length)
                    .closest('.custom-control').find('.wj-kolor').css({background: k || 'transparent', border: k ? 'none' : '1px solid #c3c2b7'});
            });

            var d = dane.tryby[tryb];
            var n = d.etykiety.length;
            $('#wykres-brak').text(TRYBY[tryb].brak).toggleClass('d-none', n >= 2);
            $('#wykres-wykresy').toggleClass('d-none', n < 2);

            var start = zakres ? Math.max(0, n - zakres) : 0;
            var punkty = n - start <= 31;
            wykresGlosy.data.labels = wykresPrzyrost.data.labels = d.etykiety.slice(start);
            wykresGlosy.data.datasets = zaznaczone.map(function (i) {
                var nazwa = dane.jednostki[i].nazwa;
                return zbiorDanych(nazwa, (d.glosy[nazwa] || []).slice(start), kolorJednostki[i], punkty);
            });
            wykresPrzyrost.data.datasets = zaznaczone.map(function (i) {
                var nazwa = dane.jednostki[i].nazwa;
                return zbiorDanych(nazwa, (d.przyrost[nazwa] || []).slice(start), kolorJednostki[i], punkty);
            });
            wykresGlosy.update();
            wykresPrzyrost.update();
        }

        lista.on('change', 'input', rysuj);
        $('#wykres-tryb').on('click', 'button', function () {
            ustawTryb($(this).data('tryb'));
        });
        $('#wykres-zakres').on('click', 'button', function () {
            $(this).addClass('active').siblings().removeClass('active');
            zakres = +$(this).data('zakres');
            rysuj();
        });
        ustawTryb(tryb);
    });

    $(function () {
        var modal = $('#bezPrzekierowania');
        var zapytanie = null;

        function stan(tekst, klasa) {
            $('#podglad-stan').attr('class', 'p-3 ' + (klasa || 'text-muted')).text(tekst).removeClass('d-none');
        }

        function pokaz(id) {
            modal.find('.list-group-item').removeClass('active').filter('[data-id="' + id + '"]').addClass('active');
            $('#podglad-naglowki, #podglad-html, #podglad-tekst').addClass('d-none');
            stan('Pobieranie wiadomości ze skrzynki…');
            if (zapytanie) {
                zapytanie.abort();
            }
            zapytanie = $.getJSON('/admin/przekierowania/podglad/' + id)
                .done(function (w) {
                    var naglowki = $('#podglad-naglowki').empty().removeClass('d-none');
                    [['Od', w.od], ['Do', w.do], ['Alias', w.alias], ['Temat', w.temat], ['Data', w.data]].forEach(function (n) {
                        if (n[1]) {
                            naglowki.append($('<div>').append($('<strong>').text(n[0] + ': '), document.createTextNode(n[1])));
                        }
                    });
                    if (w.zalaczniki.length) {
                        naglowki.append($('<div>').append($('<strong>').text('Załączniki: '), document.createTextNode(w.zalaczniki.join(', '))));
                    }
                    $('#podglad-stan').addClass('d-none');
                    if (w.html) {
                        // linki otwierane w nowej karcie; skrypty z wiadomosci zablokowane przez sandbox
                        $('#podglad-html').removeClass('d-none').prop('srcdoc', '<base target="_blank">' + w.html);
                    } else if (w.tekst) {
                        $('#podglad-tekst').removeClass('d-none').text(w.tekst);
                    } else {
                        stan('Wiadomość nie ma treści tekstowej.');
                    }
                })
                .fail(function (x, status) {
                    if (status !== 'abort') {
                        stan((x.responseJSON && x.responseJSON.blad) || 'Nie udało się pobrać wiadomości.', 'text-danger');
                    }
                });
        }

        var maile = $('#maile');
        var maileId = null;

        function wczytajMaile() {
            var tabela = $('#maile-tabela').addClass('d-none');
            $('#maile-stan').attr('class', 'text-muted').text('Pobieranie maili ze skrzynki…').removeClass('d-none');
            $.getJSON('/admin/przekierowania/maile/' + maileId)
                .done(function (d) {
                    var tbody = tabela.find('tbody').empty();
                    if (!d.maile.length) {
                        $('#maile-stan').text('Brak wiadomości dla tej reguły.');
                        return;
                    }
                    $('#maile-stan').addClass('d-none');
                    d.maile.forEach(function (m) {
                        var akcje = $('<td>');
                        if (!m.dostepna) {
                            akcje.append($('<span class="text-muted">').text('brak w skrzynce'));
                        } else if (!m.linki.length) {
                            akcje.append($('<span class="text-muted">').text('brak linków'));
                        } else {
                            if (!m.rozpoznano) {
                                akcje.append($('<small class="d-block text-warning">').text('Nie rozpoznano linku „Potwierdź” - wszystkie linki:'));
                            }
                            m.linki.forEach(function (l) {
                                akcje.append($('<a target="_blank" rel="noopener noreferrer" class="btn btn-sm mr-1 mb-1 potwierdz">')
                                    .addClass(m.potwierdzono ? 'btn-outline-success' : 'btn-success')
                                    .attr({href: l.url, title: l.url}).data('id', m.id)
                                    .text(m.rozpoznano ? 'Potwierdź' : (l.tekst || l.url).substring(0, 40)));
                            });
                        }
                        akcje.append($('<small class="d-block text-success stan-potwierdzenia">').text(m.potwierdzono ? 'potwierdzono ' + m.potwierdzono : ''));
                        tbody.append($('<tr>').toggleClass('text-muted', !!m.potwierdzono).append(
                            $('<td style="white-space: nowrap;">').text(m.data),
                            $('<td>').text(m.alias),
                            $('<td>').append($('<a href="#" class="podglad">').attr('data-id', m.id).text(m.temat || '(bez tematu)')),
                            akcje
                        ));
                    });
                    tabela.removeClass('d-none');
                })
                .fail(function (x) {
                    $('#maile-stan').attr('class', 'text-danger').text((x.responseJSON && x.responseJSON.blad) || 'Nie udało się pobrać maili.');
                });
        }

        $(document).on('click', '.maile', function () {
            maileId = $(this).data('id');
            $('#maile-regula').text($(this).data('alias'));
            maile.modal('show');
            wczytajMaile();
        });
        $('#maile-odswiez').on('click', wczytajMaile);

        // link otwiera sie normalnie w nowej karcie, w tle zapisujemy potwierdzenie
        $(document).on('click', '.potwierdz', function () {
            var przycisk = $(this);
            $.post('/admin/przekierowania/potwierdzono/' + przycisk.data('id'), {_token: '{{ csrf_token() }}'}, function (d) {
                var wiersz = przycisk.closest('tr').addClass('text-muted');
                wiersz.find('.potwierdz').removeClass('btn-success').addClass('btn-outline-success');
                wiersz.find('.stan-potwierdzenia').text('potwierdzono ' + d.potwierdzono);
            });
        });

        $(document).on('click', '.podglad', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            // podglad z okna "Maile" - Bootstrap 4 nie obsluguje dwoch modali naraz
            var otwarty = $('.modal.show').not(modal);
            if (otwarty.length) {
                otwarty.one('hidden.bs.modal', function () { modal.modal('show'); }).modal('hide');
            } else {
                modal.modal('show');
            }
            pokaz(id);
        });
    });
</script>
@endsection
