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

    $panel = [
        'center' => [
            'width' => 9,
        ],
        'right' => [
            'width' => 3,
            'class' => 'home-no-padding',
        ],
    ];

    //
    $banners = [
        ['img'=>'/img/banner/01.png','alt'=>'a','url'=>'http://www.baidu.com'],
        ['img'=>'/img/banner/02.png','alt'=>'a','url'=>'http://www.baidu.com'],
        ['img'=>'/img/banner/03.png','alt'=>'a','url'=>'http://www.baidu.com'],
        ['img'=>'/img/banner/04.png','alt'=>'a','url'=>'http://www.baidu.com'],
    ];
    return view('pages.index',compact('panel', 'banners', 'main_config'));
});

Route::get('/company/show/{id}/{tab?}', 'CompanyController@show');
Route::get('/circle/dist/{province?}/{city?}/{district?}', 'BusinessCircleController@ajax_getBydist');
Route::get('/company/dynamic/{company_id}/{lastTime?}', 'CompanyDynamicController@ajax_getByCompany');

Route::auth();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/profile', "UserController@profile");
    Route::get('/user/relevancy', "UserController@relevancy_company");
    Route::post('/user/relevancy', "UserController@saveRelevancy");
    Route::post('/user/saveProfile', "UserController@saveProfile");

    Route::get('/company/edit', "CompanyController@edit");
    Route::post('/company/edit', "CompanyController@update");

    Route::get('/company/dynamic/add', "CompanyController@dynamic_add");
    Route::post('/company/dynamic/add', "CompanyController@dynamic_create");
    Route::post('/company/dynamic/upload', "CompanyController@uploadAttachment");

    Route::get('/company/relevancy/user', "UserController@getRelevancyUser");
    Route::post('/company/relevancy/edit', "UserController@getRelevancyUser");
    Route::post('/company/relevancy/apply', "UserController@getRelevancyUser");

    Route::get('/company/relevancy/apply/{id}', "UserController@applyRelevancyUser");
    Route::get('/company/relevancy/admin/{id}', "UserController@adminRelevancyUser");
    Route::get('/company/relevancy/delete/{id}', "UserController@deleteRelevancyUser");
});
