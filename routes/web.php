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
    Route::post('/possession/store', 'PossessionController@store');
    Route::put('/possession/update/{id}', 'PossessionController@update');
    Route::delete('/possession/{id}', 'PossessionController@destroy');

    // Favorite
    Route::post('/possession/favorite/{id}', 'PossessionController@favorite');

    // Tag
    Route::post('/possession/addTag/{id}', 'PossessionController@addTag');
    Route::delete('/possession/removeTag/{id}/{tagId}', 'PossessionController@removeTag');

    // Share
    Route::post('/possession/addShare/{id}', 'PossessionController@addShare');
    Route::delete('/possession/removeShare/{id}/{shareId}', 'PossessionController@removeShare');

    // User
    Route::get('/user/byNameOrEmail/{name}', 'UserController@byNameOrEmail');

});
