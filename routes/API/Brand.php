<?php


Route::group(['as' => 'brands.', 'namespace' => 'Brand'], function () {

    Route::get('/getBrands', 'BrandController@getBrands')->name('brands.get');
    Route::get('/brands', 'BrandController@getBrands')->name('brands.get');
    Route::get('/brandsDetails/{id}', 'BrandController@getBrandDetails')->name('brands.get');

});