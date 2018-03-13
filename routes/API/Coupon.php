<?php


Route::group(['as' => 'coupons.', 'namespace' => 'Coupon'], function () {

    Route::get('/getCoupons', 'CouponController@getCoupons')->name('coupons.get');
    Route::get('/coupons', 'CouponController@getCoupons')->name('coupons.get');

});

