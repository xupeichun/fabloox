<?php


Route::group(['as' => 'products.' , 'namespace' => 'NewOnFabloox'], function () {

    Route::get('/getNewOnFabloox', 'NewOnFablooxController@newOnFabloox')->name('get');

});
