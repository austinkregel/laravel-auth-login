<?php

return [
    'base-layout' => 'vendor.spark.layouts.app',
    'prefix' => 'auth',
    'profile' => [
        'enabled' => true,
        'route' => 'profile',
    ],
    'redirect-to' => '/',
    'middleware' => ['web', 'guest'],
    'middleware-api' => ['api']
];
