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

    // Possession
    Route::get('/possession/byUser', 'PossessionController@byUser');
    Route::post('/possession', 'PossessionController@store');
    Route::delete('/possession/{id}', 'PossessionController@destroy');

    Route::post('/possession/addTag/{id}', 'PossessionController@addTag');
    Route::get('/possession/addShare/{id}/{userId}', 'PossessionController@addShare');

    Route::post('/possession/favorite/{id}', 'PossessionController@favorite');


    // User
    Route::get('/user/byNameOrEmail/{name}', 'UserController@byNameOrEmail');

});
