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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth', 'prefix' => 'words'], function(){
    Route::get('/create', 'WordController@create');
    Route::get('/', 'WordController@index');
    Route::post('/store', 'WordController@store');
    Route::get('/learn', 'WordController@learn');
    Route::get('/get', 'WordController@getWords');
    Route::post('/post', 'WordController@post');
});