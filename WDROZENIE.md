# Instrukcja wdrożenia OSP Świerzawa - Laravel

## Konfiguracja wykonana

### Baza danych MySQL (NOWA)
- Host: h22.seohost.pl
- Baza: srv36592_osp-2026
- Użytkownik: srv36592_osp-2026
- Hasło: hDDeXEGy5ueN78fCd55v

### Zaimportowane dane z oryginalnej bazy
| Tabela | Rekordów |
|--------|----------|
| aktualnosci | 856 |
| aktualnosci_zdjecia | 1146 |
| aktualnosciGalerie | 556 |
| aktualnosciWideo | 4 |
| podstrony | 9 |
| testy | 2 |
| testy_pytania | 198 |
| users | 6 |
| video | 11 |
| sponsorzy | 1 |
| dokumenty | 3 |

### Użytkownicy (loginy zachowane z oryginalnej bazy)
| ID | Login | Email | Imię | Nazwisko |
|----|-------|-------|------|----------|
| 1 | Mateusz | 123 | Mateusz | Ratajczak |
| 4 | MateuszK | MateuszK | Mateusz | Kwieciński |
| 5 | sebastian | sebastian | Sebastian | Król |
| 6 | WaldekK | 998waldek@wp.pl | Waldemar | Kwieciński |
| 7 | Dominika | szwajcerdominika@gmail.com | Dominika | Sz |
| 8 | Marcin | rodzinka426@gmail.com | Marcin | L |

**Hasła zostały zachowane z oryginalnej bazy danych.**

### Moduły nauki (testy)
1. **Wiedza ogólna** (url: wiedza-ogolna) - Test ma za zadanie zweryfikować wiedzę ogólną na poziomie średnim.
2. **Pierwsza pomoc** (url: pierwsza-pomoc) - Kurs ma na celu weryfikację podstawowych umiejętności udzielania pierwszej pomocy.

## Wdrożenie na serwer

### 1. Upload plików
Przenieś cały katalog projektu na serwer do katalogu głównego domeny.

### 2. Konfiguracja Document Root
Ustaw document root na folder `/public` projektu.

Jeśli nie możesz zmienić document root, plik `.htaccess` w głównym katalogu przekieruje ruch do `/public`.

### 3. Uprawnienia
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 4. Zmienne środowiskowe
Plik `.env` jest już skonfigurowany:
- APP_ENV=production
- APP_DEBUG=false
- APP_URL=https://osp-swierzawa.pl

### 5. Cache produkcyjny
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Generowanie sitemap
Odwiedź: https://osp-swierzawa.pl/sitemap

## Panel administracyjny
- URL: https://osp-swierzawa.pl/osp-admin125
- Loginy i hasła: zachowane z oryginalnej bazy

## Struktura folderów
```
/
├── app/                 # Kontrolery, Modele
├── bootstrap/           # Pliki startowe Laravel
├── config/              # Konfiguracja
├── database/            # Migracje, Seedery
├── public/              # Document root
│   ├── assets/          # CSS, JS, Obrazy szablonu
│   ├── upload/          # Przesłane pliki (zdjęcia, dokumenty)
│   ├── js/              # Własne skrypty JS
│   ├── vid/             # Filmy
│   └── pdf/             # Pliki PDF
├── resources/views/     # Widoki Blade
├── routes/              # Routing
├── storage/             # Logi, Cache, Sesje
└── vendor/              # Zależności Composer
```

## Kontakt
W razie problemów sprawdź logi: `storage/logs/laravel.log`
