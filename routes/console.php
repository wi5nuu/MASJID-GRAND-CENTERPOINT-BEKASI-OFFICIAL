<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-fetch jadwal shalat Bekasi setiap hari jam 00:05 WIB
Schedule::command('shalat:fetch')->dailyAt('00:05')->timezone('Asia/Jakarta');
