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


    if(Auth::user()){
        $companies = Auth::user()->able_companies();
        if(count($companies) > 0){
            $p_ids = \App\Models\Category::whereRaw('id in ('.$companies[0]->company->business_categories.')')->lists('p_id');
            $categories = \App\Models\Category::whereIn('id', $p_ids)->get();
        }
    }
    if(!isset($categories) || count($categories) == 0){
        $categories = \App\Helpers\CategoryHelper::getCategory(0);
    }
    return view('pages.index',compact('panel', 'banners', 'main_config','categories'));
});

Route::get('/search/{search_key}', 'SearchController@search');
Route::get('/search_item/{search_key}/{page?}', 'SearchController@ajax_search');
Route::get('/company/show/{id}/{tab?}', 'CompanyController@show');
Route::get('/circle/dist/{province?}/{city?}/{district?}', 'BusinessCircleController@ajax_getBydist');
Route::get('/company_dynamic/{company_id}/{lastTime?}', 'CompanyDynamicController@ajax_getByCompany');
Route::get('/index/dynamic/{lastTime?}', 'CompanyController@ajax_getIndexCompany');
Route::get('img/{file?}', 'FileController@showImg')->where('file', '(.*)');
Route::get('file/{file?}', 'FileController@showFile')->where('file', '(.*)');

Route::auth();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/profile', "UserController@profile");
    Route::get('/user/relevancy', "UserController@relevancy_company");
    Route::post('/user/relevancy', "UserController@saveRelevancy");
    Route::post('/user/saveProfile', "UserController@saveProfile");
    Route::post('/user/message/add', "UserController@addUserMessage");
    Route::get('/user/message/show', "UserController@showUserMessage");
    Route::get('/user/message/show_item/{lastId}', "UserController@ajax_getUserMessage");

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
