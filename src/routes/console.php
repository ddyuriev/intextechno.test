<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\ClearExpiredUsersJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

$interval = config('users.cleanup_interval');
Schedule::job(new ClearExpiredUsersJob)
    ->cron("*/{$interval} * * * *");
