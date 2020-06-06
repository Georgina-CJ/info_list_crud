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

Route::get('accountInfo', 'api\AccountInfoController@index');
Route::get('accountInfo/{id}', 'api\AccountInfoController@show');
Route::post('accountInfo', 'api\AccountInfoController@store');
Route::put('accountInfo/{id}', 'api\AccountInfoController@update');
Route::delete('accountInfo', 'api\AccountInfoController@destroy');
