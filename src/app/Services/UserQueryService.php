<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class UserQueryService
{
    public function all(): array
    {
        $nicknames = Redis::smembers('users');

        if (empty($nicknames)) {
            return [];
        }

        $users = [];

        foreach ($nicknames as $nickname) {
            $user = Redis::hgetall("user:$nickname");

            if (!empty($user)) {
                $users[] = $user;
            }
        }

        return $users;
    }
}
