<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//Cada minuto ejecuta el comando
Schedule::command('facturas:procesar-inserts')->everyMinute();

// everyFifteenMinutes
// everyMinute