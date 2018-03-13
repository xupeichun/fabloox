<?php


Route::group(['as' => 'faqs.', 'namespace' => 'Faqs'], function () {

    Route::get('/getFaqs', 'FaqsController@getFaqs')->name('get');
    Route::get('/faqs', 'FaqsController@getFaqs')->name('get');

});
