
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="www.rataq.pl">
    <title>Panel administracyjny</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        body {
            padding-top: 5rem;
        }
        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }
        .mozliwaOdpVal {
            padding: 2%;
        }
        .note-editable{
            min-height:250px;
        }
    </style>
    
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/admin">Start <span class="sr-only">Główna</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aktualności</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="/admin/blog/dodaj">Dodaj wpis</a>
          <a class="dropdown-item" href="/admin/blog">Wszystkie</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="podstrony" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Podstrony</a>
        <div class="dropdown-menu" aria-labelledby="podstrony">
          <a class="dropdown-item" href="/admin/podstrona/historia">Historia</a>
          <a class="dropdown-item" href="/admin/podstrona/zarzad">Zarząd</a>
          <a class="dropdown-item" href="/admin/podstrona/wyposazenie">Wyposażenie</a>
          <a class="dropdown-item" href="/admin/podstrona/statut">Statut</a>
          <a class="dropdown-item" href="/admin/podstrona/jakosc-powietrza">Jakość powietrza</a>
          <a class="dropdown-item" href="/admin/podstrona/polityka-prywatnosci">Polityka prywatności</a>
          <a class="dropdown-item" href="/admin/podstrona/zbiorka-elektro-smieci-osp-swierzawa">Elektro-śmieci</a>
          <a class="dropdown-item" href="/admin/podstrona/wsparcie">Wspieraj</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="/admin/dokumenty">Dokumenty <span class="sr-only">Główna</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="/admin/sponsorzy">Sponsorzy</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="/admin/dokumenty">Lista mailingowa <span class="sr-only">Główna</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pytania</a>
        <div class="dropdown-menu" aria-labelledby="dropdown02">
          <a class="dropdown-item" href="/admin/kursy">Kursy</a>
          <a class="dropdown-item" href="/admin/kursy/wyniki">Wyniki</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/wspierajacy"> <span class="sr-only">Wspierający</span></a>
      </li>
      @if(request()->user() && request()->user()->role === 'super_admin')
      <li class="nav-item">
        <a class="nav-link" href="/admin/administratorzy">Administratorzy</a>
      </li>
      @endif
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <a href="/admin/profile" class="btn btn-info my-2 my-sm-0 mr-2">Profil / API</a>
      <a href="/admin/zmien-haslo" class="btn btn-danger my-2 my-sm-0 mr-2">Zmień hasło</a>
      <a href="/admin/wyloguj" class="btn btn-secondary my-2 my-sm-0">Wyloguj</a>
    </form>
  </div>
</nav>

<main role="main" class="container">

  @yield('tresci')

</main><!-- /.container -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script>window.jQuery || document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"><\/script>')</script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.edytor').summernote();
            });
        </script>
</body>
</html>
