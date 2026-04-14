@extends('admin.theme')
@section('tresci')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Dashboard</h3>
        <span class="text-muted">Witaj, {{ request()->user()->name }}!</span>
    </div>

    <!-- Statystyki glowne -->
    <div class="row">
        <!-- Artykuly -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/admin/blog" class="text-decoration-none">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fa fa-newspaper text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-uppercase text-muted mb-1">Artykuly</div>
                                <div class="h4 mb-0 font-weight-bold text-dark">{{ $artykuly }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <span class="small text-primary">Zobacz wszystkie &rarr;</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Dokumenty -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/admin/dokumenty" class="text-decoration-none">
                <div class="card border-left-success shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fa fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-uppercase text-muted mb-1">Dokumenty</div>
                                <div class="h4 mb-0 font-weight-bold text-dark">{{ $dokumenty }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <span class="small text-success">Zobacz wszystkie &rarr;</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Sponsorzy -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/admin/sponsorzy" class="text-decoration-none">
                <div class="card border-left-warning shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fa fa-handshake text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-uppercase text-muted mb-1">Sponsorzy</div>
                                <div class="h4 mb-0 font-weight-bold text-dark">{{ $sponsorzy }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <span class="small text-warning">Zobacz wszystkie &rarr;</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Testy -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/admin/kursy" class="text-decoration-none">
                <div class="card border-left-secondary shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-secondary">
                                    <i class="fa fa-clipboard-list text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-uppercase text-muted mb-1">Testy / Konkursy</div>
                                <div class="h4 mb-0 font-weight-bold text-dark">{{ $testy }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <span class="small text-secondary">Zobacz wszystkie &rarr;</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Druga linia -->
    <div class="row">
        <!-- Administratorzy -->
        <div class="col-xl-3 col-md-6 mb-4">
            @if(request()->user() && request()->user()->role === 'super_admin')
            <a href="/admin/administratorzy" class="text-decoration-none">
            @endif
                <div class="card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-info">
                                    <i class="fa fa-users text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-uppercase text-muted mb-1">Administratorzy</div>
                                <div class="h4 mb-0 font-weight-bold text-dark">{{ $uzytkownicy }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        @if(request()->user() && request()->user()->role === 'super_admin')
                        <span class="small text-info">Zarzadzaj &rarr;</span>
                        @else
                        <span class="small text-muted">Tylko super admin</span>
                        @endif
                    </div>
                </div>
            @if(request()->user() && request()->user()->role === 'super_admin')
            </a>
            @endif
        </div>

        <!-- Video -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <div class="icon-circle bg-danger">
                                <i class="fa fa-video text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-uppercase text-muted mb-1">Materialy video</div>
                            <div class="h4 mb-0 font-weight-bold text-dark">{{ $video }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zdjecia -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <div class="icon-circle bg-dark">
                                <i class="fa fa-images text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-uppercase text-muted mb-1">Zdjecia w galeriach</div>
                            <div class="h4 mb-0 font-weight-bold text-dark">{{ $zdjecia }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tokeny API -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/admin/profile" class="text-decoration-none">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fa fa-key text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-uppercase text-muted mb-1">Tokeny API</div>
                                <div class="h5 mb-0 font-weight-bold text-dark">Profil</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <span class="small text-primary">Zarzadzaj &rarr;</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Szybkie akcje -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fa fa-bolt mr-2"></i>Szybkie akcje</h6>
                </div>
                <div class="card-body">
                    <a href="/admin/blog/dodaj" class="btn btn-primary mr-2 mb-2"><i class="fa fa-plus mr-1"></i> Nowy artykul</a>
                    <a href="/admin/dokumenty/dodaj" class="btn btn-success mr-2 mb-2"><i class="fa fa-plus mr-1"></i> Nowy dokument</a>
                    <a href="/admin/sponsorzy/dodaj" class="btn btn-warning mr-2 mb-2"><i class="fa fa-plus mr-1"></i> Nowy sponsor</a>
                    <a href="/admin/kursy/dodaj" class="btn btn-secondary mr-2 mb-2"><i class="fa fa-plus mr-1"></i> Nowy test</a>
                    <a href="/admin/profile" class="btn btn-info mr-2 mb-2"><i class="fa fa-key mr-1"></i> Tokeny API</a>
                    @if(request()->user() && request()->user()->role === 'super_admin')
                    <a href="/admin/administratorzy" class="btn btn-dark mr-2 mb-2"><i class="fa fa-users-cog mr-1"></i> Administratorzy</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary { border-left: 4px solid #007bff !important; }
    .border-left-success { border-left: 4px solid #28a745 !important; }
    .border-left-warning { border-left: 4px solid #ffc107 !important; }
    .border-left-info { border-left: 4px solid #17a2b8 !important; }
    .border-left-secondary { border-left: 4px solid #6c757d !important; }
    .border-left-danger { border-left: 4px solid #dc3545 !important; }
    .border-left-dark { border-left: 4px solid #343a40 !important; }
    .text-xs { font-size: .75rem; }
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .icon-circle i {
        font-size: 1.25rem;
    }
    .card {
        border: none;
        border-radius: 0.35rem;
        transition: transform 0.15s ease-in-out;
    }
    a .card:hover {
        transform: translateY(-3px);
    }
    .card-footer {
        border-top: 1px solid #e3e6f0;
    }
    .text-decoration-none:hover {
        text-decoration: none !important;
    }
</style>
@endsection
