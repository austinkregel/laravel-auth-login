<?php

return [
    'base-layout' => 'layouts.app',
    'prefix' => 'auth',
    'profile' => [
        'enabled' => false,
        'route' => 'profile',
    ],
    'redirect-to' => '/',
    'middleware' => ['web', 'guest'],
    'middleware-api' => ['api'],
    'events' => [
        'login' => [
            'failed' => function ($reqeuest, $reason) {
                
            },
            'success' => function ($reqeuest, $reason) {
                
            }
        ]
    ]
];
