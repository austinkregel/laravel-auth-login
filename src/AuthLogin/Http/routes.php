<?php
Route::group(['prefix' => config('kregel.auth-login.prefix'), 'as' => 'auth-login::'], function(){
  Route::get('/', function(){
    return redirect(route('auth-login::login'));
  });
  Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
  Route::post('login', ['as' => 'post-login', 'uses' => 'Auth\AuthController@postLogin']);
  
  
  Route::get('register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
  Route::post('register', ['as' => 'post-register', 'uses' => 'Auth\AuthController@postRegister']);
  
  Route::get('email', ['as' => 'email', 'uses' => 'Auth\PasswordController@getEmail']);
  Route::post('email', ['as' => 'post-email', 'uses' => 'Auth\PasswordController@postEmail']);
  
  Route::get('reset', ['as' => 'reset', 'uses' => 'Auth\PasswordController@getReset']);
  Route::post('reset', ['as' => 'post-reset', 'uses' => 'Auth\PasswordController@postReset']);

});
