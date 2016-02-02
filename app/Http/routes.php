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

// Notre expertise
Route::get('/expertise', function(){
    return view('others.expertise');
});

// Impression 3D
Route::get('/3dprint', function(){
    return view('others.3dprint');
});

// Conditions générales
Route::get('/legal', function(){
    return view('others.legal');
});

// Politique de confidentialité
Route::get('/privacy', function(){
    return view('others.privacy');
});

// Contact
Route::get('/contact', 'ContactController@getContact');
Route::post('/contact', 'ContactController@postContact');

// Utilisateurs connect�s seulement
Route::group(['middleware' => 'auth'], function () {
    // Logout
    Route::get('/logout', 'Auth\AuthController@getLogout');

    // Upload model
    Route::get('/upload-model', 'ModelController@getUploadModel');
    Route::post('/upload-model', 'ModelController@postUploadModel');

    // Account
    Route::get('/account', 'UserController@getAccount');
    Route::post('/account', 'UserController@postAccount');

    // Change password
    Route::get('/password/change', 'UserController@getPasswordChange');
    Route::post('/password/change', 'UserController@postPasswordChange');

    // New order
    Route::post('/order/new', 'OrderController@postNewOrder');

    // My models
    Route::get('/models', 'UserController@getModels');

    // My orders
    Route::get('/orders', 'UserController@getOrders');

    // Utilisateurs possède le modèle
    Route::group(['middleware' => 'userOwnModel'], function () {

        // Edit model
        Route::get('/edit-model/{id}', 'ModelController@getEditModel')->where('id', '[0-9]+');

        // Get file
        Route::get('/file/{id}', 'ModelController@getFile')->where('id', '[0-9]+');

        // Delete model
        Route::get('/delete-model/{id}', 'ModelController@getDeleteModel')->where('id', '[0-9]+');

        // Ajax Edit model
        Route::post('/edit-model', 'AjaxController@postEditModel');

        // Ajax Check dimensions
        Route::post('/check-dimensions', 'AjaxController@postCheckDimensions');
    });

    // Utilisateurs possède la commande
    Route::group(['middleware' => 'userOwnOrder'], function () {
        Route::get('/order/{id}', 'OrderController@getOrder')->where('id', '[0-9]+');
    });

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
