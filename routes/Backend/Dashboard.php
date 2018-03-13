<?php

/**
 * All route names are prefixed with 'admin.'.
 */
//加admin前缀
Route::get('dashboard', 'DashboardController@index')->name('dashboard');


