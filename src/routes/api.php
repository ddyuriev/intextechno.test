<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Config;

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('throttle:' .
        Config::get('throttle.register.max_attempts') . ',1'
    );
