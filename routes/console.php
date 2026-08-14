<?php

use App\Http\Controllers\AutodebetController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// SCHEDULER AUTODEBET SETIAP HARI (JAM 00:05 PAGI)
Schedule::call(function () {
    (new AutodebetController)->runAutodebetProcess();
})->dailyAt('10:00')->timezone('Asia/Jakarta')->name('autodebet:proses_otomatis');
