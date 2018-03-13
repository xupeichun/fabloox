<?php

Route::group(['prefix' => 'ajax','as'=> 'ajax.'], function () {
    Route::get('/getProduct', 'Api\Rakuten\RakutenApiController@getProducts')->name('get.products');
    Route::get('/getProduct2', 'Api\VigLink\VigLinkApiController@getProducts')->name('get.products2');
});

