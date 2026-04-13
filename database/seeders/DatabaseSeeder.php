<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@osp-swierzawa.pl',
            'password' => Hash::make('Admin123!'),
            'imie' => 'Administrator',
            'nazwisko' => 'OSP',
            'admin' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Podstrony
        $podstrony = [
            [
                'url' => 'historia',
                'tytul' => 'Historia OSP Świerzawa',
                'tresc' => '<p>Historia jednostki OSP Świerzawa.</p>',
                'zdjecie' => '/upload/osp.jpg',
            ],
            [
                'url' => 'zarzad',
                'tytul' => 'Zarząd OSP Świerzawa',
                'tresc' => '<p>Skład zarządu OSP Świerzawa.</p>',
                'zdjecie' => '/upload/osp.jpg',
            ],
            [
                'url' => 'wyposazenie',
                'tytul' => 'Wyposażenie OSP Świerzawa',
                'tresc' => '<p>Wyposażenie jednostki OSP Świerzawa.</p>',
                'zdjecie' => '/upload/osp.jpg',
            ],
            [
                'url' => 'statut',
                'tytul' => 'Statut OSP Świerzawa',
                'tresc' => '<p>Statut jednostki OSP Świerzawa.</p>',
                'zdjecie' => '/upload/osp.jpg',
            ],
            [
                'url' => 'wsparcie',
                'tytul' => 'Wsparcie OSP Świerzawa',
                'tresc' => '<p>Informacje o wsparciu OSP Świerzawa.</p>',
                'zdjecie' => '/upload/osp.jpg',
            ],
            [
                'url' => 'polityka-prywatnosci',
                'tytul' => 'Polityka prywatności',
                'tresc' => '<p>Polityka prywatności strony OSP Świerzawa.</p>',
                'zdjecie' => '/upload/osp.jpg',
            ],
            [
                'url' => 'jakosc-powietrza',
                'tytul' => 'Jakość powietrza w Świerzawie',
                'tresc' => '<p>Informacje o jakości powietrza w Świerzawie.</p>',
                'zdjecie' => '/upload/osp.jpg',
            ],
            [
                'url' => 'zbiorka-elektro-smieci-osp-swierzawa',
                'tytul' => 'Zbiórka elektro-śmieci',
                'tresc' => '<p>Informacje o zbiórce elektro-śmieci.</p>',
                'zdjecie' => '/upload/osp.jpg',
            ],
        ];

        foreach ($podstrony as $podstrona) {
            DB::table('podstrony')->insert(array_merge($podstrona, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Przykładowy test
        DB::table('testy')->insert([
            'tytul' => 'Test podstawowy - pożary',
            'url' => 'test-podstawowy-pozary',
            'opis' => 'Test sprawdzający podstawową wiedzę o pożarach',
            'zdjecie' => '/upload/osp.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Przykładowe pytanie
        DB::table('testy_pytania')->insert([
            'testy_id' => 1,
            'pytanie' => 'Jaki numer alarmowy należy wybrać w przypadku pożaru?',
            'wyjasnienie' => 'Numer 112 to europejski numer alarmowy, 998 to numer do straży pożarnej.',
            'odpowiedzi' => '112,998,997,999',
            'prawidlowa' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Przykładowy artykuł
        DB::table('aktualnosci')->insert([
            'tytul' => 'Witamy na nowej stronie OSP Świerzawa',
            'url' => 'witamy-na-nowej-stronie-osp-swierzawa',
            'poprzedni_url' => '',
            'tresc' => '<p>Witamy na nowej stronie internetowej Ochotniczej Straży Pożarnej w Świerzawie. Strona została całkowicie zmigrowana do nowego systemu.</p>',
            'zdjecie' => '/upload/osp.jpg',
            'kategoria' => 'Aktualności',
            'autor' => 1,
            'zalaczniki' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Przykładowe video
        DB::table('video')->insert([
            'tytul' => 'Przykładowe wideo OSP',
            'url_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'miniatura' => '/upload/osp.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
