<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class UserCleanupService
{
    public function cleanupExpired(int $ttlMinutes): int
    {
        $now = time();
        $expiredBefore = $now - ($ttlMinutes * 60);

        $nicknames = Redis::smembers('users');
        $removed = 0;

        foreach ($nicknames as $nickname) {
            $user = Redis::hgetall("user:$nickname");

            if (empty($user)) {
                Redis::srem('users', $nickname);
                $removed++;

                continue;
            }

            if (($user['created_at'] ?? 0) < $expiredBefore) {
                Redis::multi();
                Redis::del("user:$nickname");
                Redis::srem('users', $nickname);
                Redis::exec();

                $removed++;
            }
        }

        return $removed;
    }
}
