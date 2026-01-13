<?php

return [
    'register' => [
        'max_attempts' => env('REGISTER_THROTTLE_MAX_ATTEMPTS', 5),
    ],
];
