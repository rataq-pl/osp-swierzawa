@extends('admin.theme')
@section('tresci')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Statystyki glowne -->
    <div class="row">
        <!-- Artykuly -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Artykuly</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $artykuly }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumenty -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dokumenty</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dokumenty }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sponsorzy -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sponsorzy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sponsorzy }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Administratorzy -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Administratorzy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $uzytkownicy }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Druga linia statystyk -->
    <div class="row">
        <!-- Testy -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Testy / Konkursy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $testy }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Materialy video</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $video }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-video fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zdjecia -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Zdjecia w galeriach</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $zdjecia }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-images fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabele z ostatnimi elementami -->
    <div class="row">
        <!-- Ostatnie artykuly -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ostatnie artykuly</h6>
                    <a href="/admin/blog" class="btn btn-sm btn-primary">Zobacz wszystkie</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tytul</th>
                                    <th>Kategoria</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artykulyOstatnie as $art)
                                <tr>
                                    <td>{{ Str::limit($art->tytul, 40) }}</td>
                                    <td><span class="badge badge-secondary">{{ $art->kategoria }}</span></td>
                                    <td>
                                        <a href="/admin/blog/edycja/{{ $art->id }}" class="btn btn-xs btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <a href="/b/{{ $art->url }}" target="_blank" class="btn btn-xs btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ostatnie dokumenty -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Ostatnie dokumenty</h6>
                    <a href="/admin/dokumenty" class="btn btn-sm btn-success">Zobacz wszystkie</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nazwa</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dokumentyOstatnie as $dok)
                                <tr>
                                    <td>{{ Str::limit($dok->nazwa, 50) }}</td>
                                    <td>
                                        <a href="/admin/dokumenty/edytuj/{{ $dok->id }}" class="btn btn-xs btn-outline-success"><i class="fas fa-edit"></i></a>
                                        <a href="{{ $dok->url }}" target="_blank" class="btn btn-xs btn-outline-secondary"><i class="fas fa-download"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sponsorzy -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-warning">Sponsorzy</h6>
                    <a href="/admin/sponsorzy" class="btn btn-sm btn-warning">Zarzadzaj sponsorami</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($sponsorzyLista as $sponsor)
                        <div class="col-md-2 col-sm-4 col-6 mb-3 text-center">
                            <a href="/admin/sponsorzy/edycja/{{ $sponsor->id }}">
                                <img src="{{ $sponsor->zdjecie }}" alt="{{ $sponsor->nazwa }}" class="img-fluid mb-2" style="max-height: 80px; object-fit: contain;">
                                <p class="small mb-0">{{ Str::limit($sponsor->nazwa, 20) }}</p>
                            </a>
                        </div>
                        @endforeach
                        @if(count($sponsorzyLista) == 0)
                        <div class="col-12 text-center text-muted">
                            <p>Brak sponsorow. <a href="/admin/sponsorzy/dodaj">Dodaj pierwszego!</a></p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Szybkie akcje -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Szybkie akcje</h6>
                </div>
                <div class="card-body">
                    <a href="/admin/blog/dodaj" class="btn btn-primary mr-2 mb-2"><i class="fas fa-plus"></i> Nowy artykul</a>
                    <a href="/admin/dokumenty/dodaj" class="btn btn-success mr-2 mb-2"><i class="fas fa-plus"></i> Nowy dokument</a>
                    <a href="/admin/sponsorzy/dodaj" class="btn btn-warning mr-2 mb-2"><i class="fas fa-plus"></i> Nowy sponsor</a>
                    <a href="/admin/testy/dodaj" class="btn btn-secondary mr-2 mb-2"><i class="fas fa-plus"></i> Nowy test</a>
                    <a href="/admin/profile" class="btn btn-info mr-2 mb-2"><i class="fas fa-key"></i> Tokeny API</a>
                    @if(request()->user() && request()->user()->role === 'super_admin')
                    <a href="/admin/administratorzy" class="btn btn-dark mr-2 mb-2"><i class="fas fa-users-cog"></i> Administratorzy</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-warning { border-left: 4px solid #f6c23e !important; }
    .border-left-info { border-left: 4px solid #36b9cc !important; }
    .border-left-secondary { border-left: 4px solid #858796 !important; }
    .border-left-danger { border-left: 4px solid #e74a3b !important; }
    .border-left-dark { border-left: 4px solid #5a5c69 !important; }
    .text-xs { font-size: .7rem; }
    .text-gray-300 { color: #dddfeb !important; }
    .text-gray-800 { color: #5a5c69 !important; }
    .card { border: none; }
    .btn-xs { padding: .125rem .35rem; font-size: .75rem; }
</style>
@endsection
