<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', 'Admin\DashboardController@index');
Route::get('/stats/{page_id}', 'Admin\DashboardController@showStat');
