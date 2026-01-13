<?php

namespace App\Http\Controllers;

use App\Services\UserRegistrationService;
use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    public function store(RegisterUserRequest $request, UserRegistrationService $service)
    {
        $service->register(
            $request->string('nickname'),
            $request->file('avatar')
        );

        return response()->json(['status' => 'ok']);
    }
}
