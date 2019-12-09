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

//Route::group(['middleware'=>['EnableCrossRequestMiddleware']],function (){
    Route::any('category/read/{id}', 'Api\CategoryController@read');
    Route::any('category', 'Api\CategoryController@index');
    Route::any('category/add', 'Api\CategoryController@add');
    Route::get('category/del', 'Api\CategoryController@del');
    Route::post('category/update/{id}', 'Api\CategoryController@update');

//});


Route::any('product', 'Api\ProductController@index');
Route::post('product/add', 'Api\ProductController@add');
Route::get('product/del', 'Api\ProductController@del');
Route::post('product/update/{id}', 'Api\ProductController@update');

Route::any('nav/read/{id}','Api\NavController@read');
Route::any('nav','Api\NavController@index');
Route::any('nav/add','Api\NavController@add');
Route::any('nav/del/{id}','Api\NavController@del');
Route::post('nav/update/{id}','Api\NavController@update');
Route::any('nav/img_up','Api\NavController@pic');
