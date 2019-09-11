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

Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');


Route::group(['middleware' => 'auth:api'], function (){
    Route::get('user/details','Api\UserController@getUserDetails');
    Route::get('user/posts','Api\UserController@getPostsOfAUser');
    Route::get('timeline','Api\UserController@getTimeline');
    Route::get('user/albums','Api\UserController@getAlbumsOfAUser');
    Route::get('album/posts','Api\AlbumController@getPhotosOfAnAlbum');

    Route::post('album','Api\AlbumController@create');
    Route::put('user','Api\UserController@updateUserDetails');
    Route::post('post','Api\PostController@create');


});

