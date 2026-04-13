@extends('admin.theme')
@section('tresci')
<div class="starter-template">
    {!!$komunikat!!}
<div class="table-responsive">    
    <table class="table table-striped table-sm">
        <a href="/admin/dokumenty/dodaj" class="btn btn-dark float-right">DODAJ</a>
        <h3>Wszystkie dokumenty</h3>
      <thead>
        <tr>
          <th>#</th>
          <th>Nazwa</th>
          <th>Opis</th>
          <th style="width:30%;">Pliki</th>
          <th>Zarządzaj</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dokumenty as $q)
            @php
                $dokumenty2 = $q -> dokumenty;
                $dokumenty2 = explode(',', $dokumenty2);
            @endphp
            <tr>
                <td>{{$q -> id}}</td>
                <td>{{$q -> nazwa}}</td>
                <td>{{$q -> opis}}</td>
                <td style="width:30%;">
                    @foreach ($dokumenty2 as $w)
                        @php
                            //var_dump($ikony);
                            $rozszerzenie = explode('.', $w);
                            $rozszerzenie = $rozszerzenie[1];
                            
                                $ikona = '<a href="'.$w.'" target="_blank"><img src="/assets/icons/'.$ikony[$rozszerzenie].'" style="max-width:50px;"/></a>';
                            
                        @endphp
                        {!!$ikona!!}
                    @endforeach
                </td>
                <td>
                    <a href="/admin/dokumenty/usun/{{$q -> id}}" class="btn btn-danger">USUŃ</a>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection