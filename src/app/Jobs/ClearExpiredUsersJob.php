<?php

namespace App\Jobs;

use App\Services\UserCleanupService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ClearExpiredUsersJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct() {}

    public function handle(UserCleanupService $service): void
    {
        $service->cleanupExpired(
            config('users.ttl_minutes')
        );
    }
}
