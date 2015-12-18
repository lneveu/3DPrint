<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
});

// Utilisateurs connect�s seulement
Route::group(['middleware' => 'auth'], function () {
    // Logout
    Route::get('/logout', 'Auth\AuthController@getLogout');
});

// Utilisateurs non connect�s seulement
Route::group(['middleware' => 'guest'], function () {
    // Register
    Route::get('/register', 'Auth\AuthController@getRegister');
    Route::post('/register', 'Auth\AuthController@postRegister');

    // Login
    Route::post('/login', 'Auth\AuthController@postLogin');

    // Password reset link request routes...
    Route::get('/password/email', 'Auth\PasswordController@getEmail');
    Route::post('/password/email', ['as' => 'password.email.post', 'uses' => 'Auth\PasswordController@postEmail']);

    // Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\PasswordController@postReset']);
});
