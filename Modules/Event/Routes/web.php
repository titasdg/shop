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

Route::prefix('event')->group(function() {
    Route::get('/', 'EventController@index');
});
Route::get('admin/event/{event_id}/photo/{id}','EventController@destroyPhoto');
Route::resource('admin/event', 'EventController');
