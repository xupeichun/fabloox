<?php

Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {

    Route::post('/register', 'RegisterController@register');
    Route::post('/login/social', 'SocialLoginController@socialLogin');
    Route::post('/login', 'LoginController@login');
    Route::post('/password/forget', 'ForgotPasswordController@sendEmail');
    Route::post('/password/reset', 'ResetPasswordController@resetPassword');
    Route::post('/password/change', 'ResetPasswordController@changePassword');

});




