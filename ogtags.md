# Naprawa duplikatów tagów Open Graph na blogu

## Kontekst problemu

Na stronie `https://meble-to-my.pl/meble-jelenia-gora/blog/...` Facebook Sharing Debugger wykrywa **dwa zestawy tagów Open Graph**.

Pierwszy zestaw (prawdopodobnie z głównego layoutu) ma `og:image = /assets/images/logo.png` i wygrywa jako "kanoniczny". Drugi zestaw (z widoku wpisu blogowego) ma poprawny obrazek wpisu, ale ląduje pod prefiksem `og:temporal:*`, bo FB traktuje go jako duplikat.

**Objaw:** przy udostępnianiu wpisu bloga na Facebooku pokazuje się logo firmy zamiast miniaturki wpisu.

**Dowód z FB Debuggera:**
```
og:image                        https://meble-to-my.pl/assets/images/logo.png
og:temporal:twitter:image       https://meble-to-my.pl/storage/blog/SSgJ9M9k88ApBDevGQmWvqaZKP0t5FQys1ymXJ01.jpg
```

Prefiks `og:temporal:*` pojawia się **wyłącznie** wtedy, gdy parser FB widzi powtórzone bloki OG w jednym dokumencie.

---

## Zadania do wykonania

### 1. Zidentyfikuj źródło duplikatów

Przeszukaj projekt i znajdź **wszystkie** miejsca, w których renderowane są tagi `og:*`, `twitter:*` oraz `<meta name="description">`:

```bash
grep -rn "og:image\|og:title\|og:description\|twitter:card" resources/views/
grep -rn "og:image\|SEOMeta\|OpenGraph\|seotools" app/ config/
```

Sprawdź w szczególności:
- `resources/views/layouts/` (główne layouty — np. `app.blade.php`, `master.blade.php`)
- `resources/views/blog/` lub `resources/views/posts/` (widok pojedynczego wpisu)
- `config/seotools.php` jeśli używany jest pakiet `artesaos/seotools`
- Service providery dorzucające meta tagi globalnie
- Ewentualne `@push('head')` / `@stack('meta')` które mogą sumować tagi zamiast je nadpisywać

### 2. Przeanalizuj wyrenderowany HTML

Pobierz faktyczny HTML strony i potwierdź, że są dwa `og:image`:

```bash
curl -sL "https://meble-to-my.pl/meble-jelenia-gora/blog/jak-zaplanowac-salon-gdy-metraz-klamie-meble-ktore-optycznie-powiekszaja-przestrzen" | grep -i "og:\|twitter:"
```

Zanotuj dokładnie, które tagi pojawiają się dwa razy i w jakiej kolejności. To pokaże, który template wstrzykuje logo.

### 3. Zastosuj jedno źródło prawdy dla meta tagów

Wybierz **jedno** podejście i trzymaj się go konsekwentnie w całym projekcie.

#### Opcja A — Blade sections (rekomendowana, jeśli NIE używasz pakietu SEO)

**W layoucie bazowym** (`layouts/app.blade.php` lub odpowiednik):

```blade
<head>
    {{-- stałe tagi --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- meta tagi — nadpisywalne w widokach --}}
    @hasSection('meta')
        @yield('meta')
    @else
        {{-- fallback WYŁĄCZNIE dla stron bez własnych meta --}}
        <title>Meble To My</title>
        <meta property="og:type" content="website">
        <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif
</head>
```

**W widoku wpisu blogowego** (np. `resources/views/blog/show.blade.php`):

```blade
@section('meta')
    <title>{{ $post->title }} | Blog Meble To My</title>
    <meta name="description" content="{{ $post->excerpt }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:image" content="{{ asset('storage/blog/' . $post->image) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $post->title }}">
    <meta property="og:site_name" content="Meble To My">
    <meta property="og:locale" content="pl_PL">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->excerpt }}">
    <meta name="twitter:image" content="{{ asset('storage/blog/' . $post->image) }}">
@endsection
```

**WAŻNE:**
- Upewnij się, że layout **nie zawiera** stałych tagów `og:*` poza sekcją fallback (`@else`).
- Jeżeli istnieje `@push('head')` albo `@stack('meta')` — sprawdź, czy widok bloga nie dorzuca tam drugiego zestawu tagów.
- Nie mieszaj `@section` i `@push` dla tych samych meta tagów.

#### Opcja B — pakiet `artesaos/seotools`

Jeśli w `composer.json` jest `artesaos/seotools`, usuń **wszystkie** ręczne `<meta property="og:...">` z bladeów.

**W kontrolerze wpisu:**

```php
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

public function show($slug)
{
    $post = Post::where('slug', $slug)->firstOrFail();

    SEOMeta::setTitle($post->title . ' | Blog Meble To My');
    SEOMeta::setDescription($post->excerpt);
    SEOMeta::setCanonical(url()->current());

    OpenGraph::setTitle($post->title);
    OpenGraph::setDescription($post->excerpt);
    OpenGraph::setUrl(url()->current());
    OpenGraph::setType('article');
    OpenGraph::addImage(
        asset('storage/blog/' . $post->image),
        ['width' => 1200, 'height' => 630]
    );

    TwitterCard::setType('summary_large_image');
    TwitterCard::setTitle($post->title);
    TwitterCard::setDescription($post->excerpt);
    TwitterCard::setImage(asset('storage/blog/' . $post->image));

    return view('blog.show', compact('post'));
}
```

**W layoucie bazowym — TYLKO to:**

```blade
{!! SEO::generate() !!}
```

I **nic więcej** odnośnie meta tagów. Żadnych ręcznych `<meta property="og:...">` w żadnym blade'u.

### 4. Dodaj wymiary obrazka

Facebook wymaga minimum 600×315 px (zalecane 1200×630 px). Bez wymiarów FB czasem odrzuca obrazek i sięga po fallback. Zawsze dołączaj:

```html
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="...">
```

Upewnij się też, że obrazki wgrywane przez CMS bloga mają wymagane minimum.

### 5. Zweryfikuj poprawkę

Po wdrożeniu zmian:

**a) Wyczyść cache Laravela:**

```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

**b) Sprawdź w HTML, czy jest już tylko JEDEN `og:image`:**

```bash
curl -sL "https://meble-to-my.pl/meble-jelenia-gora/blog/jak-zaplanowac-salon-gdy-metraz-klamie-meble-ktore-optycznie-powiekszaja-przestrzen" | grep 'property="og:image"' | grep -v "width\|height\|alt"
```

Powinna się pojawić **dokładnie jedna** linia ze zdjęciem wpisu (nie logo).

**c) Ponownie scrapuj w Facebook Debuggerze:**

1. Otwórz https://developers.facebook.com/tools/debug/
2. Wklej URL wpisu
3. Kliknij **"Scrape Again"** — często potrzeba 2–3 razy, żeby FB wyczyścił swój cache
4. Upewnij się, że:
    - W sekcji "Open Graph Properties" **nie ma** już prefiksu `og:temporal:*`
    - `og:image` pokazuje właściwe zdjęcie wpisu (nie logo)
    - W "Link Preview" widać miniaturkę wpisu

### 6. Raport końcowy

Po zakończeniu zgłoś:
- Które pliki zostały zmodyfikowane (pełne ścieżki)
- Gdzie był źródłowy duplikat (który layout/partial/service provider)
- Które podejście zostało wybrane (A czy B)
- Wynik ponownego scrape w FB Debuggerze (treść sekcji "Open Graph Properties")
- Czy problem dotyczy tylko wpisów blogowych, czy także innych podstron (kategorie, produkty, strona główna)

---

## Czego NIE robić

- **Nie usuwaj** starych tagów "na pałę" bez sprawdzenia, czy nie są używane przez inne strony (np. stronę główną, kategorie — tam fallback z logo może być pożądany).
- **Nie próbuj** rozwiązać problemu przez dodanie `og:image` wyżej w `<head>`. FB parsuje wszystkie wystąpienia — kolejność nie eliminuje duplikatu.
- **Nie ruszaj** cache aplikacji bez `php artisan view:clear` po zmianach w bladeach.
- **Nie mieszaj** dwóch podejść (ręczne `<meta>` + pakiet SEO jednocześnie) — to właśnie najczęstsza przyczyna takich duplikatów.
- **Nie zapomnij** o ponownym scrape w FB Debuggerze — bez tego użytkownicy nadal będą widzieć starą, złą miniaturę.
