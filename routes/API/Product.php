<?php


//Route::group(['as' => 'products.', 'middleware' => 'auth'], function () {
//
//    Route::get('/getproduct', 'Rakuten\RakutenApiController@getProducts')->name('products.get');
//    Route::get('/getbrands', 'Brand\BrandController@getBrands')->name('brands.get');
//
//});


Route::group(['as' => 'products.'], function () {
//    Route::get('/getProduct', 'Rakuten\RakutenApiController@getProducts')->name('get');
    Route::get('/products', 'Product\ProductController@index')->name('get');
    Route::get('/getProduct', 'Product\ProductController@index')->name('get');
    Route::get('/getProductDetail/{linkId}', 'Product\ProductController@productDetails')->name('get');
//    Route::get('/getProduct2', 'VigLink\VigLinkApiController@getProducts')->name('get.products2');
});



