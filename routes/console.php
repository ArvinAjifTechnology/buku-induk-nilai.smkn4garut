<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

$schedule->call(function () {
    Artisan::call('db:seed', ['--class' => 'EntryYearSeeder']);
})->daily();

$schedule->call(function () {
    Artisan::call('db:seed', ['--class' => 'GraduationYearSeeder']);
})->daily();