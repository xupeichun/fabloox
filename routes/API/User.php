<?php

Route::group(['namespace' => 'User', 'as' => 'user.', 'middleware' => 'auth:api'], function () {

    Route::post('profile/update', 'ProfileController@update');
    Route::post('profile/update/password', 'ChangePasswordController@changePassword');


});
