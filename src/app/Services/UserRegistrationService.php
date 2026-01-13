<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\UploadedFile;

class UserRegistrationService
{
    public function register(string $nickname, UploadedFile $avatar): void
    {
        $path = $avatar->store('avatars', 'public');

        Redis::multi();
        Redis::sadd('users', $nickname);
        Redis::hset("user:$nickname", [
            'nickname' => $nickname,
            'avatar' => $path,
            'created_at' => time(),
        ]);
        Redis::exec();
    }
}
