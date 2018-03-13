<?php


Route::group(['namespace' => 'Notification', 'as' => 'notifications.',], function () {

    Route::get('notifications', 'NotificationController@getNotifications');

});