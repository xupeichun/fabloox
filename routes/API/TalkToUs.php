<?php


Route::group(['as' => 'talk'], function () {

    Route::post('/talk', 'TalkToUsController@talkToUs');

});