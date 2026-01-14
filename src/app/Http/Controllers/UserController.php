<?php

namespace App\Http\Controllers;

use App\Services\UserQueryService;

class UserController extends Controller
{
    public function index(UserQueryService $service)
    {
        $users = $service->all();

        return view('users.index', compact('users'));
    }
}
