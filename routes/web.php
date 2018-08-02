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

Route::get('/', 'Tree\MainController@test');

Route::post('/tree/load', 'Tree\LoadController@load');

Route::get('/list','Tree\ListController@show');
Route::post('/list/sort', 'Tree\ListController@sort');
Route::post('/list/search', 'Tree\ListController@search');
Route::get('/home', function (){ return redirect('/');});
Auth::routes();


