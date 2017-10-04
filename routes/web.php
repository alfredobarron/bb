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

// email change
Route::get('/email/change/{token}', 'UserController@emailChange');
Route::post('/email/update', 'UserController@emailUpdate');

//Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['web', 'auth']], function () {
    //Route::get('/home', 'PossessionController@index');
    Route::get('/possessions/{id?}', 'PossessionController@index');

    // Possession
    //Route::get('/possession/byUser', 'PossessionController@byUser');
    Route::get('/possession/byUser/{parentId?}', 'PossessionController@byUser');
    Route::post('/possession/store', 'PossessionController@store');
    Route::put('/possession/update/{id}', 'PossessionController@update');
    Route::delete('/possession/delete/{id}', 'PossessionController@destroy');
    Route::get('/possession/{possessionId}', 'PossessionController@viewPossession');

    // Folders
    Route::post('/possession/folder/store', 'PossessionFolderController@store');

    // Files
    Route::post('/possession/file/upload/{id}', 'PossessionFileController@upload');
    Route::post('/possession/file/upload/temp', 'PossessionFileController@uploadTemp');

    // Comments
    Route::post('/possession/comment/store', 'PossessionCommentController@store');

    // Favorite
    Route::post('/possession/favorite/{id}', 'PossessionController@favorite');

    // Tag
    Route::post('/possession/addTag/{id}', 'PossessionController@addTag');
    Route::delete('/possession/removeTag/{id}/{tagId}', 'PossessionController@removeTag');

    // Share
    Route::post('/possession/addShare/{id}', 'PossessionController@addShare');
    Route::delete('/possession/removeShare/{id}/{shareId}', 'PossessionController@removeShare');

    // User
    Route::get('/profile', 'UserController@profile');
    Route::post('/user/updateProfile/{id}', 'UserController@updateProfile');
    Route::post('/user/updatePassword/{id}', 'UserController@updatePassword');
    Route::post('/user/uploadAvatar/{id}', 'UserController@uploadAvatar');
    Route::get('/user/byNameOrEmail/{name}', 'UserController@byNameOrEmail');

});
