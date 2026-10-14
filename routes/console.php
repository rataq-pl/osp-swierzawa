<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// przekierowania poczty ze skrzynki harnas@ (wymaga CRON: * * * * * php artisan schedule:run)
Schedule::command('harnas:przekierowania')->everyFiveMinutes()->withoutOverlapping();
