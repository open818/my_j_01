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
    $main_config = [
        'logo'  => '',
        'main'  => '***网',
    ];
    return view('pages.index',['main_config'=>['']]);
});

Route::auth();

Route::get('/user/profile', "UserController@profile");

Route::post('/user/saveProfile', "UserController@saveProfile");