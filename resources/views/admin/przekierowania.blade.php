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
<script>
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
