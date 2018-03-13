<?php

Route::group(['as' => 'products.', 'namespace' => 'Category'], function () {

    Route::get('categories', 'CategoryController@index');
    Route::get('getCategories', 'CategoryController@index');

});