<?php


Route::group(['as' => 'search.', 'namespace' => 'Search'], function () {

    Route::get('/search/all', 'SearchController@getSearch');
    Route::get('/search', 'SearchController@index');


    Route::get('/search/user', 'SearchController@getUserHistory');

    Route::group(['as' => 'faqs.', 'middleware' => ['auth:api']], function () {

        Route::delete('/search/user', 'SearchController@deleteUserHistory');
        Route::delete('/search/{id}', 'SearchController@deleteSingleHistory');


    });
});
