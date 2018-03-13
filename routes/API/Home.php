<?php

Route::group(['as' => 'home.', 'namespace' => 'Home'], function () {

    Route::get('home', 'HomePageController@getHomePage');
    Route::get('getHomepage', 'HomePageController@getHomePage');

});