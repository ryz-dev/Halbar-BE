<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['apikey'], 'namespace' => 'API\V1','prefix' => 'v1'], function () {
    Route::group(['prefix' => 'dashboard','middleware' => ['jwt.verify']], function () {
        Route::post('checkout', 'CheckoutController@order');
    });
    Route::group(['prefix' => 'users'], function () {
        Route::post('login', 'UsersController@authenticate');
        Route::post('register', 'UsersController@register');
    });
    Route::group(['prefix' => 'posts'], function () {
        Route::get('', 'PostsController@index');
        Route::get('/read/{slug}', 'PostsController@read');
        Route::get('/search', 'PostsController@search');
        Route::post('/comment', 'PostsController@commentStore');
        Route::post('/count', 'PostsController@countStore');
        Route::get('/fiture', 'PostsController@embedFiture');
        Route::get('/related/{categoryId}', 'PostsController@relatedPost');
    });
    Route::group(['prefix' => 'message'], function () {
        Route::post('inbox', 'ContactController@inbox');
        Route::post('proposal', 'ContactController@proposal');
        Route::post('pengaduan', 'ContactController@pengaduan');
    });
    Route::group(['prefix' => 'testimonial'], function () {
        Route::get('', 'TestimonialController@index');
    });
    Route::group(['prefix' => 'pages'], function () {
        Route::get('', 'PagesController@index');
        Route::get('/read/{slug}', 'PagesController@read');
    });
    Route::group(['prefix' => 'menus'], function () {
        Route::get('{type}', 'MenusController@index');
        Route::get('header/{type}/{category}', 'MenusController@headerType');
    });
    Route::group(['prefix' => 'slider'], function () {
        Route::get('', 'SliderController@index');
    });
    Route::group(['prefix' => 'client'], function () {
        Route::get('', 'ClientController@index');
        Route::get('{id}', 'ClientController@read');
    });
    Route::group(['prefix' => 'team'], function () {
        Route::get('', 'TeamController@index');
        Route::get('{id}', 'TeamController@read');
    });
    Route::group(['prefix' => 'setting'], function () {
        Route::get('', 'SettingController@index');
    });
    Route::group(['prefix' => 'pricing'], function () {
        Route::get('', 'PricingController@index');
        Route::get('detail', 'PricingController@detail');
    });
    Route::group(['prefix' => 'users'], function () {
        Route::get('', 'UsersController@getUsers');
    });
    Route::group(['prefix' => 'subscribe'], function () {
        Route::get('', 'SubscribersController@index');
        Route::post('create', 'SubscribersController@store');
    });
    Route::group(['prefix' => 'download'], function(){
        Route::get('', 'DownloadController@index');
    });

    Route::group(['prefix' => 'opd'], function(){
        Route::get('', 'OpdController@index' );
        Route::get('/read/{slug}', 'OpdController@read' );
    });

    Route::group(['prefix' => 'media'], function(){
        Route::get('', 'MediaController@index');
    });
});
