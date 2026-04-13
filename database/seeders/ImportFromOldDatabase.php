<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class ImportFromOldDatabase extends Seeder
{
    protected $oldDb;

    public function run(): void
    {
        // Połączenie ze starą bazą danych
        try {
            $this->oldDb = new PDO(
                'mysql:host=localhost;dbname=srv36592_osp;charset=utf8mb4',
                'srv36592_osp',
                'BQv6VNjm',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $this->command->info('Połączono ze starą bazą danych.');
        } catch (PDOException $e) {
            $this->command->error('Nie można połączyć się ze starą bazą: ' . $e->getMessage());
            $this->command->info('Kontynuuję z danymi demonstracyjnymi...');
            return;
        }

        // Import użytkowników
        $this->importUsers();

        // Import podstron
        $this->importPodstrony();

        // Import aktualności
        $this->importAktualnosci();

        // Import testów
        $this->importTesty();

        // Import video
        $this->importVideo();

        // Import sponsorów
        $this->importSponsorzy();

        // Import dokumentów
        $this->importDokumenty();

        $this->command->info('Import zakończony pomyślnie!');
    }

    protected function importUsers()
    {
        $stmt = $this->oldDb->query('SELECT * FROM users');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'imie' => $user['imie'] ?? null,
                    'nazwisko' => $user['nazwisko'] ?? null,
                    'admin' => $user['admin'] ?? 0,
                    'created_at' => $user['created_at'] ?? now(),
                    'updated_at' => $user['updated_at'] ?? now(),
                ]
            );
        }
        $this->command->info('Zaimportowano ' . count($users) . ' użytkowników.');
    }

    protected function importPodstrony()
    {
        $stmt = $this->oldDb->query('SELECT * FROM podstrony');
        $podstrony = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($podstrony as $podstrona) {
            DB::table('podstrony')->updateOrInsert(
                ['url' => $podstrona['url']],
                [
                    'tytul' => $podstrona['tytul'],
                    'tresc' => $podstrona['tresc'],
                    'zdjecie' => $podstrona['zdjecie'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
        $this->command->info('Zaimportowano ' . count($podstrony) . ' podstron.');
    }

    protected function importAktualnosci()
    {
        $stmt = $this->oldDb->query('SELECT * FROM aktualnosci ORDER BY id');
        $aktualnosci = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($aktualnosci as $a) {
            DB::table('aktualnosci')->updateOrInsert(
                ['url' => $a['url']],
                [
                    'tytul' => $a['tytul'],
                    'poprzedni_url' => $a['poprzedni_url'] ?? '',
                    'tresc' => $a['tresc'],
                    'zdjecie' => $a['zdjecie'] ?? null,
                    'kategoria' => $a['kategoria'] ?? null,
                    'autor' => $a['autor'],
                    'zalaczniki' => $a['zalaczniki'] ?? '',
                    'created_at' => $a['created_at'] ?? now(),
                    'updated_at' => $a['updated_at'] ?? now(),
                ]
            );
        }
        $this->command->info('Zaimportowano ' . count($aktualnosci) . ' aktualności.');

        // Import zdjęć do aktualności
        try {
            $stmt = $this->oldDb->query('SELECT * FROM aktualnosci_zdjecia');
            $zdjecia = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($zdjecia as $z) {
                DB::table('aktualnosci_zdjecia')->insert([
                    'aktualnosci_id' => $z['aktualnosci_id'],
                    'zdjecie' => $z['zdjecie'],
                    'alt' => $z['alt'] ?? null,
                ]);
            }
            $this->command->info('Zaimportowano ' . count($zdjecia) . ' zdjęć do aktualności.');
        } catch (PDOException $e) {
            $this->command->warn('Brak tabeli aktualnosci_zdjecia.');
        }

        // Import galerii
        try {
            $stmt = $this->oldDb->query('SELECT * FROM aktualnosciGalerie');
            $galerie = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($galerie as $g) {
                DB::table('aktualnosciGalerie')->insert([
                    'url' => $g['url'],
                    'tytul' => $g['tytul'] ?? null,
                    'aktualnosciID' => $g['aktualnosciID'],
                ]);
            }
            $this->command->info('Zaimportowano ' . count($galerie) . ' elementów galerii.');
        } catch (PDOException $e) {
            $this->command->warn('Brak tabeli aktualnosciGalerie.');
        }

        // Import wideo do aktualności
        try {
            $stmt = $this->oldDb->query('SELECT * FROM aktualnosciWideo');
            $wideo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($wideo as $w) {
                DB::table('aktualnosciWideo')->insert([
                    'url' => $w['url'],
                    'aktualnosciID' => $w['aktualnosciID'],
                ]);
            }
            $this->command->info('Zaimportowano ' . count($wideo) . ' wideo do aktualności.');
        } catch (PDOException $e) {
            $this->command->warn('Brak tabeli aktualnosciWideo.');
        }
    }

    protected function importTesty()
    {
        $stmt = $this->oldDb->query('SELECT * FROM testy ORDER BY id');
        $testy = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($testy as $test) {
            DB::table('testy')->updateOrInsert(
                ['url' => $test['url']],
                [
                    'tytul' => $test['tytul'],
                    'opis' => $test['opis'] ?? null,
                    'zdjecie' => $test['zdjecie'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
        $this->command->info('Zaimportowano ' . count($testy) . ' testów.');

        // Import pytań
        $stmt = $this->oldDb->query('SELECT * FROM testy_pytania');
        $pytania = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pytania as $p) {
            DB::table('testy_pytania')->insert([
                'testy_id' => $p['testy_id'],
                'pytanie' => $p['pytanie'],
                'wyjasnienie' => $p['wyjasnienie'] ?? null,
                'odpowiedzi' => $p['odpowiedzi'],
                'prawidlowa' => $p['prawidlowa'],
            ]);
        }
        $this->command->info('Zaimportowano ' . count($pytania) . ' pytań.');
    }

    protected function importVideo()
    {
        try {
            $stmt = $this->oldDb->query('SELECT * FROM video');
            $video = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($video as $v) {
                DB::table('video')->insert([
                    'tytul' => $v['tytul'],
                    'url_video' => $v['url_video'],
                    'miniatura' => $v['miniatura'] ?? null,
                ]);
            }
            $this->command->info('Zaimportowano ' . count($video) . ' filmów.');
        } catch (PDOException $e) {
            $this->command->warn('Brak tabeli video.');
        }
    }

    protected function importSponsorzy()
    {
        try {
            $stmt = $this->oldDb->query('SELECT * FROM sponsorzy');
            $sponsorzy = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($sponsorzy as $s) {
                DB::table('sponsorzy')->insert([
                    'nazwa' => $s['nazwa'],
                    'zdjecie' => $s['zdjecie'] ?? null,
                    'opis' => $s['opis'] ?? null,
                    'www' => $s['www'] ?? null,
                    'facebook' => $s['facebook'] ?? null,
                    'instagram' => $s['instagram'] ?? null,
                    'tiktok' => $s['tiktok'] ?? null,
                    'twitter' => $s['twitter'] ?? null,
                    'youtube' => $s['youtube'] ?? null,
                    'created_at' => $s['created_at'] ?? now(),
                    'updated_at' => $s['updated_at'] ?? now(),
                ]);
            }
            $this->command->info('Zaimportowano ' . count($sponsorzy) . ' sponsorów.');
        } catch (PDOException $e) {
            $this->command->warn('Brak tabeli sponsorzy.');
        }
    }

    protected function importDokumenty()
    {
        try {
            $stmt = $this->oldDb->query('SELECT * FROM dokumenty');
            $dokumenty = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dokumenty as $d) {
                DB::table('dokumenty')->insert([
                    'nazwa' => $d['nazwa'],
                    'opis' => $d['opis'] ?? null,
                    'dokumenty' => $d['dokumenty'],
                ]);
            }
            $this->command->info('Zaimportowano ' . count($dokumenty) . ' dokumentów.');
        } catch (PDOException $e) {
            $this->command->warn('Brak tabeli dokumenty.');
        }
    }
}
