<?php


Route::group(['as' => 'content.', 'namespace' => 'Content'], function () {

    Route::get('/contents','ContentController@index');

});