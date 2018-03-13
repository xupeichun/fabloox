<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 10/31/17
 * Time: 4:07 PM
 */

//Route::group(['as' => 'testnotifica'], function () {
//
//    Route::get('/getBrands', 'BrandController@getBrands')->name('brands.get');
//    Route::get('/brands', 'BrandController@getBrands')->name('brands.get');
//    Route::get('/brandsDetails/{id}', 'BrandController@getBrandDetails')->name('brands.get');
//
//});

Route::get('/testnotification', 'TestNotification\TestNotificationController@getNotification');
