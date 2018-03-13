<?php

Route::group(['as' => 'search.', 'namespace' => 'Search'], function () {

    Route::get('/search', 'SearchController@index')->name('get');

});