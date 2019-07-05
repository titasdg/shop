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

Route::prefix('blog')->group(function() {
    Route::get('/', 'ApiController@index');
});

Route::get('admin/blog/{blog_id}/photo/{id}','BlogController@destroyPhoto');
Route::resource('admin/blog', 'BlogController');
