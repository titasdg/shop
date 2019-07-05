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

Route::prefix('settings')->group(function() {
    Route::get('/', 'SettingsController@index');
});

Route::resource('admin/weights', 'WeightsController');
Route::resource('admin/shipping', 'ShippingController',['except' => ['index']]);
Route::resource('admin/settings', 'SettingsController');


