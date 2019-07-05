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

Route::resource('settings', 'Api\\SettingsController', ['except' => ['create', 'edit']]);
Route::resource('products', 'Api\\ProductsController', ['except' => ['create', 'edit']]);
Route::post('submit-form', 'HomeController@send');
Route::post('send-email', 'HomeController@sendOrderEmail');