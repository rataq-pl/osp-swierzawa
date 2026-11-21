<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// przekierowania poczty ze skrzynki harnas@ (wymaga CRON: * * * * * php artisan schedule:run)
Schedule::command('harnas:przekierowania')->everyMinute()->withoutOverlapping();

// glosy pierwszych 20 jednostek rankingu osp-harnas.pl - statystyka konkurencji w /admin/przekierowania
// oraz powiadomienie e-mail o nowych glosach (HARNAS_ALERT_*); co 10 minut (2 zapytania do osp-harnas.pl),
// ostatni odczyt o 23:55 zamyka dzien
Schedule::command('harnas:konkurencja')->cron('5,15,25,35,45,55 * * * *')->timezone('Europe/Warsaw')->withoutOverlapping();
