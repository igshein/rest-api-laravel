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

Route::post('/login', 'Api\Auth\AuthController@login')->name('api-login');
Route::group(['middleware' => ['jwt-auth'] ], function () {
    Route::group(['prefix' => '/v1/songs'], function () {
        Route::get('/', 'Api\Songs\SongController@getAll')->name('get-songs');
        Route::get('/{songId}', 'Api\Song\SongController@getById')->name('get-song');
        Route::post('/','Api\Song\SongController@create')->name('create-song');
        Route::put('/{songId}','Api\Song\SongController@updateById')->name('update-song');
        Route::delete('/{songId}','Api\Song\SongController@deleteById')->name('delete-song');
    });
});
