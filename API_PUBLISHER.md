# API Publikacji Zdalnej - Dokumentacja

## Informacje podstawowe

**Base URL:** `https://twoja-domena.pl/api/v1`
**Autoryzacja:** Bearer Token (osobny system tokenów dla publikacji)
**Format:** JSON
**Content-Type:** `application/json`

---

## Autoryzacja

Wszystkie requesty (poza `/ping`) wymagają tokenu API.

### Generowanie tokenu

Tokeny generowane są przez administratora w panelu `/admin/profile`.

**Dostępne uprawnienia (abilities):**
- `blog:read` - odczyt wpisów
- `blog:create` - tworzenie wpisów
- `blog:update` - edycja wpisów
- `blog:delete` - usuwanie wpisów
- `*` - pełne uprawnienia

### Użycie tokenu

```http
Authorization: Bearer YOUR_API_TOKEN
```

lub

```http
X-API-Token: YOUR_API_TOKEN
```

---

## Obsługa treści HTML

### Dozwolone tagi HTML

API akceptuje następujące tagi HTML w polach `tresc`, `wstep`, `content`:

**Struktura tekstu:**
```html
<p>, <br>, <div>, <span>
<h1>, <h2>, <h3>, <h4>, <h5>, <h6>
<blockquote>, <pre>, <code>, <hr>
```

**Formatowanie:**
```html
<strong>, <b>, <em>, <i>, <u>, <s>, <strike>
<sub>, <sup>, <small>, <mark>
```

**Listy:**
```html
<ul>, <ol>, <li>
```

**Tabele:**
```html
<table>, <thead>, <tbody>, <tr>, <td>, <th>
```

**Media:**
```html
<img>, <figure>, <figcaption>
<a> (linki)
```

**Embedy (YouTube, Vimeo, mapy):**
```html
<iframe>, <video>, <audio>, <source>
<embed>, <object>, <param>
```

### Tagi usuwane automatycznie (bezpieczeństwo)

```html
<script>, <style>, <link>, <meta>
<form>, <input>, <button>, <select>, <textarea>
```

### Atrybuty usuwane automatycznie

- `onclick`, `onerror`, `onload` i wszystkie `on*` event handlers
- `javascript:` w atrybutach `href` i `src`
- `expression()` w stylach

---

## Endpointy

### Health Check

```http
GET /api/v1/ping
```

**Response:**
```json
{
    "success": true,
    "message": "API is running",
    "timestamp": "2024-04-11T12:00:00+00:00",
    "version": "v1"
}
```

---

### Blog

#### Lista wpisów

```http
GET /api/v1/blog
```

**Query params:**
| Parametr | Typ | Opis |
|----------|-----|------|
| `status` | string | `published` lub `draft` |
| `search` | string | Wyszukiwanie w tytule i wstępie |
| `per_page` | int | Liczba wyników na stronę (max 100) |
| `page` | int | Numer strony |

**Response:**
```json
{
    "success": true,
    "data": [...],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 73
    }
}
```

---

#### Pobierz wpis

```http
GET /api/v1/blog/{id}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "tytul": "Tytuł wpisu",
        "url": "tytul-wpisu",
        "zdjecie": "/storage/blog/2024/04/image.jpg",
        "galeria": [
            "/storage/blog/2024/04/g1.jpg",
            "/storage/blog/2024/04/g2.jpg"
        ],
        "wstep": "Krótki wstęp...",
        "tresc": "<p>Treść HTML...</p>",
        "aktywny": true,
        "seo_title": "Tytuł SEO",
        "reading_time": 5,
        "created_at": "2024-04-11",
        "updated_at": "2024-04-11"
    }
}
```

---

#### Utwórz wpis

```http
POST /api/v1/blog
Content-Type: application/json
```

**Body:**
```json
{
    "tytul": "Tytuł nowego wpisu",
    "wstep": "Krótki wstęp do artykułu (opis SEO)",
    "tresc": "<h2>Nagłówek</h2><p>Pełna treść artykułu z HTML...</p>",
    "aktywny": true,
    "url": "opcjonalny-slug",
    "seo_title": "Tytuł SEO (opcjonalnie)",
    "zdjecie": "https://example.com/image.jpg",
    "galeria": [
        "https://example.com/gallery1.jpg",
        "https://example.com/gallery2.jpg"
    ],
    "process_content_images": true
}
```

**Pola:**

| Pole | Typ | Wymagane | Opis |
|------|-----|----------|------|
| `tytul` | string | ✅ | Tytuł wpisu (max 500 znaków) |
| `tresc` | string | ✅ | Treść HTML z nagłówkami, listami, tabelami, iframe |
| `wstep` | string | ❌ | Krótki wstęp / opis SEO (max 500 znaków) |
| `aktywny` | boolean | ❌ | Czy opublikowany (domyślnie: `false` = szkic) |
| `url` | string | ❌ | Slug URL (generowany automatycznie z tytułu) |
| `seo_title` | string | ❌ | Tytuł SEO (jeśli inny niż tytuł) |
| `zdjecie` | string | ❌ | URL miniatury (lub base64) |
| `zdjecie_file` | file | ❌ | Plik miniatury (multipart/form-data) |
| `galeria` | array | ❌ | Lista URL-i zdjęć galerii |
| `process_content_images` | boolean | ❌ | Czy pobierać obrazy z treści (domyślnie: `true`) |

**Response (201):**
```json
{
    "success": true,
    "message": "Wpis został utworzony",
    "data": {
        "id": 123,
        "tytul": "Tytuł wpisu",
        "url": "tytul-wpisu",
        "zdjecie": "/storage/blog/2024/04/image.jpg",
        "galeria": ["/storage/blog/2024/04/g1.jpg", "/storage/blog/2024/04/g2.jpg"],
        "wstep": "Krótki wstęp...",
        "tresc": "<h2>Nagłówek</h2><p>Treść...</p>",
        "aktywny": true,
        "reading_time": 5,
        "created_at": "2024-04-11"
    },
    "meta": {
        "downloaded_images": 3,
        "gallery_images": 2,
        "image_errors": []
    }
}
```

---

### Galeria zdjęć

#### Automatyczna miniaturka

Jeśli nie podasz `zdjecie`, **pierwsze zdjęcie z galerii** zostanie użyte jako miniaturka wpisu.

```json
{
    "tytul": "Wpis z galerią",
    "tresc": "<p>Treść...</p>",
    "galeria": [
        "https://example.com/foto1.jpg",
        "https://example.com/foto2.jpg"
    ]
}
```
→ `foto1.jpg` będzie miniaturką i pierwszym zdjęciem galerii.

#### Formaty przesyłania galerii

**1. Array (zalecany):**
```json
{
    "galeria": [
        "https://example.com/img1.jpg",
        "https://example.com/img2.jpg"
    ]
}
```

**2. String rozdzielony przecinkami:**
```json
{
    "galeria": "https://example.com/img1.jpg,https://example.com/img2.jpg"
}
```

**3. JSON jako string:**
```json
{
    "galeria": "[\"https://example.com/img1.jpg\",\"https://example.com/img2.jpg\"]"
}
```

---

### Obsługa obrazów zewnętrznych

#### Automatyczne pobieranie

Gdy ustawisz `process_content_images: true` (domyślnie), system automatycznie:

1. **Pobiera obrazy z treści** - wszystkie `<img src="https://zewnetrzna-domena.pl/...">` są pobierane lokalnie
2. **Zamienia ścieżki** - `src` z zewnętrznej domeny → `/storage/blog/YYYY/MM/filename.jpg`
3. **Pobiera obrazy z galerii** - wszystkie URL-e są pobierane i zapisywane lokalnie
4. **Pobiera miniaturkę** - jeśli `zdjecie` to URL, jest pobierany lokalnie

#### Obsługiwane typy obrazów

- `image/jpeg` (.jpg, .jpeg)
- `image/png` (.png)
- `image/gif` (.gif)
- `image/webp` (.webp)
- `image/svg+xml` (.svg)

#### Przykład z obrazami zewnętrznymi

```json
{
    "tytul": "Nowa realizacja",
    "tresc": "<h2>Opis projektu</h2><p>Tekst...</p><img src=\"https://moja-strona.pl/uploads/foto1.jpg\"><p>Więcej...</p>",
    "zdjecie": "https://moja-strona.pl/uploads/miniatura.jpg",
    "galeria": [
        "https://moja-strona.pl/uploads/galeria1.jpg",
        "https://moja-strona.pl/uploads/galeria2.jpg"
    ],
    "aktywny": true
}
```

**Co się stanie:**
- `miniatura.jpg` → pobrane jako `/storage/blog/2024/04/20240411_120000_abc123.jpg`
- `foto1.jpg` w treści → zamienione na lokalne `/storage/blog/2024/04/...`
- `galeria1.jpg`, `galeria2.jpg` → pobrane do galerii

---

### Embedy wideo (YouTube, Vimeo)

Treść może zawierać embedy z YouTube, Vimeo i innych serwisów:

```json
{
    "tytul": "Film instruktażowy",
    "tresc": "<h2>Zobacz jak to działa</h2><p>Obejrzyj nasz film:</p><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/VIDEO_ID\" frameborder=\"0\" allowfullscreen></iframe><p>Więcej informacji poniżej...</p>",
    "aktywny": true
}
```

**Dozwolone atrybuty iframe:**
- `src`, `width`, `height`
- `frameborder`, `allowfullscreen`
- `allow` (dla nowoczesnych playerów)
- `title`, `name`, `loading`

---

#### Aktualizuj wpis

```http
PUT /api/v1/blog/{id}
Content-Type: application/json
```

Body jak przy tworzeniu, ale wszystkie pola są opcjonalne.
Przesłana galeria **zastępuje** poprzednią (nie dodaje).

---

#### Usuń wpis

```http
DELETE /api/v1/blog/{id}
```

**Response:**
```json
{
    "success": true,
    "message": "Wpis został usunięty"
}
```

---

#### Zmień status (publikuj/szkic)

```http
PATCH /api/v1/blog/{id}/status
Content-Type: application/json
```

**Body:**
```json
{
    "aktywny": true
}
```

---

#### Upload pojedynczego obrazu

```http
POST /api/v1/blog/upload-image
```

**Opcje:**

1. **Multipart file:**
   ```
   Content-Type: multipart/form-data
   image: [plik]
   ```

2. **URL:**
   ```json
   {"image_url": "https://example.com/image.jpg"}
   ```

3. **Base64:**
   ```json
   {"image_base64": "data:image/jpeg;base64,/9j/4AAQ..."}
   ```

**Response:**
```json
{
    "success": true,
    "data": {
        "path": "/storage/blog/2024/04/20240411_120000_abc123.jpg",
        "url": "https://twoja-domena.pl/storage/blog/2024/04/20240411_120000_abc123.jpg",
        "filename": "20240411_120000_abc123.jpg",
        "size": 125432,
        "mime_type": "image/jpeg"
    }
}
```

---

## Kody błędów

| Kod HTTP | Kod błędu | Opis |
|----------|-----------|------|
| 400 | `bad_request` | Nieprawidłowe żądanie |
| 401 | `missing_token` | Brak tokenu autoryzacyjnego |
| 401 | `invalid_token` | Nieprawidłowy lub wygasły token |
| 403 | `insufficient_permissions` | Brak uprawnień do operacji |
| 404 | `not_found` | Zasób nie istnieje |
| 422 | `validation_error` | Błąd walidacji danych |

**Format błędu:**
```json
{
    "success": false,
    "error": "Opis błędu",
    "code": "error_code",
    "details": {...}
}
```

---

## Przykłady użycia

### cURL - Utwórz wpis z HTML

```bash
curl -X POST https://twoja-domena.pl/api/v1/blog \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "tytul": "Artykuł z formatowaniem",
    "wstep": "Krótki opis artykułu dla SEO",
    "tresc": "<h2>Pierwszy nagłówek</h2><p>Paragraf z <strong>pogrubieniem</strong> i <em>kursywą</em>.</p><h3>Podtytuł</h3><ul><li>Element 1</li><li>Element 2</li></ul><p>Embed YouTube:</p><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/dQw4w9WgXcQ\" frameborder=\"0\" allowfullscreen></iframe>",
    "galeria": [
      "https://example.com/foto1.jpg",
      "https://example.com/foto2.jpg"
    ],
    "aktywny": true
  }'
```

### PHP - Guzzle

```php
<?php
$client = new GuzzleHttp\Client([
    'base_uri' => 'https://twoja-domena.pl/api/v1/',
    'headers' => [
        'Authorization' => 'Bearer ' . $apiToken,
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ],
]);

// Przygotuj treść HTML
$tresc = <<<HTML
<h2>Nagłówek artykułu</h2>
<p>Pierwszy paragraf z <strong>ważnym tekstem</strong>.</p>

<h3>Galeria zdjęć</h3>
<p>Poniżej znajdziesz zdjęcia z realizacji:</p>

<h3>Film instruktażowy</h3>
<iframe width="560" height="315"
    src="https://www.youtube.com/embed/VIDEO_ID"
    frameborder="0"
    allowfullscreen>
</iframe>

<h2>Podsumowanie</h2>
<ul>
    <li>Punkt pierwszy</li>
    <li>Punkt drugi</li>
    <li>Punkt trzeci</li>
</ul>
HTML;

// Zbierz URLe zdjęć
$galeriaUrls = [
    'https://moja-strona.pl/uploads/foto1.jpg',
    'https://moja-strona.pl/uploads/foto2.jpg',
    'https://moja-strona.pl/uploads/foto3.jpg',
];

try {
    $response = $client->post('blog', [
        'json' => [
            'tytul' => 'Tytuł artykułu',
            'wstep' => 'Krótki opis do SEO i podglądu',
            'tresc' => $tresc,
            'aktywny' => true,
            'galeria' => $galeriaUrls,
            'process_content_images' => true,
        ],
    ]);

    $result = json_decode($response->getBody(), true);

    if ($result['success']) {
        echo "Utworzono wpis ID: " . $result['data']['id'] . "\n";
        echo "URL: " . $result['data']['url'] . "\n";
        echo "Pobrano obrazów: " . $result['meta']['downloaded_images'] . "\n";
        echo "Zdjęć w galerii: " . $result['meta']['gallery_images'] . "\n";

        if (!empty($result['meta']['image_errors'])) {
            echo "Błędy obrazów:\n";
            foreach ($result['meta']['image_errors'] as $error) {
                echo "  - " . $error . "\n";
            }
        }
    }
} catch (GuzzleHttp\Exception\ClientException $e) {
    $error = json_decode($e->getResponse()->getBody(), true);
    echo "Błąd: " . ($error['error'] ?? $e->getMessage()) . "\n";
}
```

### JavaScript - Fetch

```javascript
const apiToken = 'YOUR_API_TOKEN';
const baseUrl = 'https://twoja-domena.pl/api/v1';

async function publishArticle(data) {
    try {
        const response = await fetch(`${baseUrl}/blog`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${apiToken}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if (result.success) {
            console.log('Utworzono wpis:', result.data.id);
            console.log('Pobrano obrazów:', result.meta.downloaded_images);
            return result.data;
        } else {
            console.error('Błąd:', result.error);
            return null;
        }
    } catch (error) {
        console.error('Błąd sieci:', error);
        return null;
    }
}

// Użycie
publishArticle({
    tytul: 'Artykuł z JavaScript',
    tresc: `
        <h2>Nagłówek</h2>
        <p>Treść z <strong>formatowaniem</strong>.</p>
        <iframe src="https://www.youtube.com/embed/VIDEO_ID"
                width="560" height="315"
                frameborder="0" allowfullscreen></iframe>
    `,
    galeria: [
        'https://example.com/img1.jpg',
        'https://example.com/img2.jpg'
    ],
    aktywny: true
});
```

---

## Mapowanie pól (API → Baza danych)

| Pole API | Pole w bazie | Uwagi |
|----------|--------------|-------|
| `tytul` | `title` | Wymagane |
| `tresc` | `content` | Wymagane, HTML dozwolony |
| `wstep` | `seo_description` | Opis SEO |
| `url` | `slug` | Auto-generowany jeśli brak |
| `aktywny` | `ready` | Boolean |
| `zdjecie` | `image` | Ścieżka lokalna po pobraniu |
| `galeria` | `gallery` | JSON array ścieżek |
| `seo_title` | `seo_title` | Opcjonalny tytuł SEO |
| - | `reading_time` | Auto-obliczany (słowa/200) |

---

## Changelog

### v1.1 (2024-04)
- Dodano obsługę `<iframe>` dla embedów YouTube/Vimeo
- Dodano obsługę tagów multimedialnych (`<video>`, `<audio>`)
- Automatyczna miniaturka z pierwszego zdjęcia galerii
- Obsługa wielu formatów przesyłania galerii (array, string, JSON)
- Dekodowanie encji HTML w treści

### v1.0 (2024-03)
- Pierwsza wersja API
- Podstawowe operacje CRUD na wpisach
- Pobieranie obrazów z zewnętrznych URL
- System tokenów autoryzacyjnych
