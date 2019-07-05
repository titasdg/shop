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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/mail', 'HomeController@mail');
Route::post('/send', 'HomeController@send');


Route::resource('admin/users', 'Admin\\UsersController');
Route::post('/page', 'GraphController@publishToPage');

Route::group(['middleware' => [
    'auth'
]], function(){
     Route::get('/admin/blog/fb', 'Admin\\UsersController@fb');

    // Route::get('/user', 'GraphController@retrieveUserProfile');

    Route::post('/user', 'GraphController@publishToProfile');



});



