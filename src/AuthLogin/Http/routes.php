<?php

Route::group(['prefix' => config('kregel.auth-login.prefix'), 'as' => 'auth-login::', 'namespace' => 'Auth'], function () {
    Route::group(['middleware' => config('kregel.auth-login.middleware')], function () {
        Route::get('/', function () {
            return redirect(route('auth-login::login'));
        });
        Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
        Route::post('login', ['as' => 'post-login', 'uses' => 'AuthController@postLogin']);


        Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
        Route::post('register', ['as' => 'post-register', 'uses' => 'AuthController@postRegister']);

        Route::get('email', ['as' => 'email', 'uses' => 'PasswordController@getEmail']);
        Route::post('email', ['as' => 'post-email', 'uses' => 'PasswordController@postEmail']);

        Route::get('reset/{code?}', ['as' => 'reset', 'uses' => 'PasswordController@getReset']);
        Route::post('reset/{code?}', ['as' => 'post-reset', 'uses' => 'PasswordController@postReset']);

    });
    Route::group(['middleware' => ['web']], function(){
        Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
    });

});

Route::group(['prefix' => config('kregel.auth-login.prefix') . '/api', 'as' => 'auth-login::api.', 'middleware' => config('kregel.auth-login.middleware-api')], function () {
    Route::post('authenticate', ['before' => 'jwt-auth', 'as' => 'authenticate', 'uses' => 'Auth\JWTAuthController@authenticate']);
});