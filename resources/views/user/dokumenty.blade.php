@extends('user.theme')
@section('tresci')
    <section>
        <div class="gap black-layer opc8 overlap144">
            <div class="fixed-bg2" style="background-image: url(/upload/blog/cars-burning-scaled.jpg); background-attachment:fixed;"></div>
            <div class="container">
                <div class="pg-tp-wrp">
                    <h1 itemprop="headline">{{$tytul}}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" title="" itemprop="url">Start</a></li>
                        <li class="breadcrumb-item active">Dokumenty</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="gap">
            <div class="container">
                <div class="cnt-wrp">
                    <div class="row">
                        <div class="sec-tl">
                            <span>Lista ważnych dokumentów:</span>
                            <h2 itemprop="headline">OSP <span class="theme-clr">Świerzawa</span></h2>
                        </div>
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Opis</th>
                                <th scope="col">Dokumenty</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($dokumenty as $q)
                                    <tr>
                                        <th scope="row">{{$q -> id}}</th>
                                        <td>{{$q -> nazwa}}</td>
                                        <td>{{$q -> opis}}</td>
                                        <td>
                                            @php

                                                $dokumenty = explode(',', $q -> dokumenty);
                                                for($i=0;$i<count($dokumenty);$i++){
                                                    $w = $dokumenty[$i];
                                                    $rozszerzenie = explode('.', $w);
                                                    $rozszerzenie = $rozszerzenie[1];
                            
                                                    $ikona = '<a href="'.$w.'" target="_blank"><img src="/assets/icons/'.$ikony[$rozszerzenie].'" style="max-width:50px;"/></a>';
                                                    echo $ikona;
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection