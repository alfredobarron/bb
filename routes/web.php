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

//Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/home', 'PossessionController@index');
    Route::get('/possession/all/byUser', 'PossessionController@byUser');
    Route::post('/possession/store', 'PossessionController@store');
});
