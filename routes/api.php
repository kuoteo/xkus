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
Route::group(['middleware'=>'api'],function(){
    Route::any('productshow',['uses'=>'Api\ShowController@productshow']);
    Route::any('homepageshow',['uses'=>'Api\ShowController@homepageshow']);
    Route::any('photoshow',['uses'=>'Api\ShowController@photoshow']);
    Route::any('visionshow',['uses'=>'Api\ShowController@visionshow']);
    Route::any('videoshow',['uses'=>'Api\ShowController@videoshow']);

});
