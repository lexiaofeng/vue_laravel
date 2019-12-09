<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//
//Route::get('member/{id}', 'MemberController@info')->where('id','[0-9]+');
//
//
//Route::get('test1', ['uses' => 'StudentController@test1']);
//
//Route::any('query1', ['uses' => 'StudentController@query1']);


