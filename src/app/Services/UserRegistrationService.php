<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redis;

class UserRegistrationService
{
    public function register(string $nickname, UploadedFile $avatar): void
    {
        $path = $avatar->store('avatars', 'public');

        Redis::multi();
        Redis::sadd('users', $nickname);
        Redis::hMSet("user:$nickname", [
            'nickname' => $nickname,
            'avatar' => $path,
            'created_at' => time(),
        ]);
        Redis::exec();
    }
}
