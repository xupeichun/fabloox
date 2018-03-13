<?php


Route::group(['as' => 'influencer.', 'namespace' => 'Influencer'], function () {

    Route::get('/influencers/search', 'InfluencerController@searchInfluencer')->name('search.get');
    Route::get('/getInfluencers/search', 'InfluencerController@searchInfluencer')->name('search.get');
    Route::get('/getInfluencers', 'InfluencerController@getInfluencers')->name('influencers.get');
    Route::get('/influencers', 'InfluencerController@getInfluencers')->name('influencers.get');
    Route::get('/getVideos', 'InfluencerController@getVideos')->name('influencers.vidoes.get');

});