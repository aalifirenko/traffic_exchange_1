<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'PublicController@index')->name('home');
Route::get('/supra', 'PublicController@supra')->name('supra');
Route::get('/chaser', 'PublicController@chaser')->name('chaser');
Route::get('/cresta', 'PublicController@cresta')->name('cresta');
Route::get('/gt86', 'PublicController@gt86')->name('gt86');
Route::get('/laurel', 'PublicController@laurel')->name('laurel');
Route::get('/mark2', 'PublicController@mark2')->name('mark2');
Route::get('/silvia', 'PublicController@silvia')->name('silvia');
Route::get('/skyline', 'PublicController@skyline')->name('skyline');
Route::get('/verossa', 'PublicController@verossa')->name('verossa');

Auth::routes();