<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('throttle:'.
        Config::get('throttle.register.max_attempts').',1'
    );
