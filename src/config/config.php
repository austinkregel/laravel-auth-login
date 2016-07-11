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
        // Someone tried to login
        'login' => [
            'failed' => function ($request, $reason,  $failed){

            },
            'success' => function ($request, $reason, $failed) {

            }
        ],
        // Someone chose to log out.
        'logout' => [
            'success' => function ($request, $reason, $failed) {

            }
        ],
        // Someone reset a password
        'reset' =>[
            'success' => function ($request, $reason, $failed) {

            }
        ],
        // Someone requested a password to be reset
        'password' => [
            'failed' => function ($request, $reason,  $failed){

            },
            'success' => function ($request, $reason, $failed) {

            }
        ],
        // Someone tried to register
        'register' => [
            'failed' => function ($request, $reason,  $failed){

            },
            'success' => function ($request, $reason, $failed) {

            }
        ],
    ],
    
];
