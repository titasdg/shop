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

Route::middleware('auth:api')->get('/order', function (Request $request) {
    return $request->user();
});
Route::put('order/status/{id}/{value}','ApiController@status');
Route::post('/order/storeOrder','ApiController@storeOrder');
Route::resource('orders', 'ApiController', ['except' => ['create', 'edit']]);