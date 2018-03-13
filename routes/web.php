<?php

/**
 * Global Routes
 * Routes that are used between both frontend and backend.
 */



// Switch between the included languages
Route::get('lang/{lang}', 'LanguageController@swap');


Route::any('api/mock/{id}', 'Mock\MockController@index');

Route::get('/commands', function () {


//    \App\Models\Access\User\User::whereHas();

    $string = ['data' => "This is the Euro symbol '€'."];

//    return collect($string);

    return response()->json($string);


//        \Illuminate\Support\Facades\Artisan::call('passport:client',[
//           '--personal' => 'default'
//        ]);
//
//

//
//    $data = `cd /var/log/apache2/ && ln -s /var/www/fabloox.crewlogix.com/storage/logs/laravel.log`;
//
//
//    echo "LOGS: ==   <pre> $data </pre>";
//
//    $output = `cd /var/www/fabloox.crewlogix.com && tail -n100 storage/logs/laravel.log`;
//
////    $output = `cd /var/www/fabloox.crewlogix.com && tail -n100 php artisan passport:client --presonal`;
//
//    echo "LOGS: ==   <pre> $output </pre>";

//    echo base_path();

//    `base_path()/php artisan passport:install --personal`;

});


/* ----------------------------------------------------------------------- */

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__ . '/Frontend/');
});

/* ----------------------------------------------------------------------- */

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    includeRouteFiles(__DIR__ . '/Backend/');

});


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

    includeRouteFiles(__DIR__ . '/Ajax/');

});

Route::group(['middleware' => 'admin'], function () {

    Route::get('admin/mockResonses',
        ['as' => 'admin.mockResonses.index', 'uses' => 'Admin\MockResonseController@index']);
    Route::post('admin/mockResonses',
        ['as' => 'admin.mockResonses.store', 'uses' => 'Admin\MockResonseController@store']);
    Route::get('admin/mockResonses/create',
        ['as' => 'admin.mockResonses.create', 'uses' => 'Admin\MockResonseController@create']);
    Route::put('admin/mockResonses/{mockResonses}',
        ['as' => 'admin.mockResonses.update', 'uses' => 'Admin\MockResonseController@update']);
    Route::patch('admin/mockResonses/{mockResonses}',
        ['as' => 'admin.mockResonses.update', 'uses' => 'Admin\MockResonseController@update']);
    Route::delete('admin/mockResonses/{mockResonses}',
        ['as' => 'admin.mockResonses.destroy', 'uses' => 'Admin\MockResonseController@destroy']);
    Route::get('admin/mockResonses/{mockResonses}',
        ['as' => 'admin.mockResonses.show', 'uses' => 'Admin\MockResonseController@show']);
    Route::get('admin/mockResonses/{mockResonses}/edit',
        ['as' => 'admin.mockResonses.edit', 'uses' => 'Admin\MockResonseController@edit']);


    Route::get('admin/pushNotifications',
        ['as' => 'admin.pushNotifications.index', 'uses' => 'Admin\PushNotificationController@index']);
    Route::post('admin/pushNotifications',
        ['as' => 'admin.pushNotifications.store', 'uses' => 'Admin\PushNotificationController@store']);
    Route::get('admin/pushNotifications/create',
        ['as' => 'admin.pushNotifications.create', 'uses' => 'Admin\PushNotificationController@create']);
    Route::put('admin/pushNotifications/{pushNotifications}',
        ['as' => 'admin.pushNotifications.update', 'uses' => 'Admin\PushNotificationController@update']);
    Route::patch('admin/pushNotifications/{pushNotifications}',
        ['as' => 'admin.pushNotifications.update', 'uses' => 'Admin\PushNotificationController@update']);
    Route::delete('admin/pushNotifications/{pushNotifications}',
        ['as' => 'admin.pushNotifications.destroy', 'uses' => 'Admin\PushNotificationController@destroy']);
    Route::get('admin/pushNotifications/{pushNotifications}',
        ['as' => 'admin.pushNotifications.show', 'uses' => 'Admin\PushNotificationController@show']);
    Route::get('admin/pushNotifications/{pushNotifications}/edit',
        ['as' => 'admin.pushNotifications.edit', 'uses' => 'Admin\PushNotificationController@edit']);


    Route::get('admin/brandVideos', ['as' => 'admin.brandVideos.index', 'uses' => 'Admin\BrandVideoController@index']);
    Route::post('admin/brandVideos', ['as' => 'admin.brandVideos.store', 'uses' => 'Admin\BrandVideoController@store']);
    Route::get('admin/brandVideos/create',
        ['as' => 'admin.brandVideos.create', 'uses' => 'Admin\BrandVideoController@create']);
    Route::put('admin/brandVideos/{brandVideos}',
        ['as' => 'admin.brandVideos.update', 'uses' => 'Admin\BrandVideoController@update']);
    Route::patch('admin/brandVideos/{brandVideos}',
        ['as' => 'admin.brandVideos.update', 'uses' => 'Admin\BrandVideoController@update']);
    Route::delete('admin/brandVideos/{brandVideos}',
        ['as' => 'admin.brandVideos.destroy', 'uses' => 'Admin\BrandVideoController@destroy']);
    Route::get('admin/brandVideos/{brandVideos}',
        ['as' => 'admin.brandVideos.show', 'uses' => 'Admin\BrandVideoController@show']);
    Route::get('admin/brandVideos/{brandVideos}/edit',
        ['as' => 'admin.brandVideos.edit', 'uses' => 'Admin\BrandVideoController@edit']);


    Route::get('admin/faqs', ['as' => 'admin.faqs.index', 'uses' => 'Admin\FaqsController@index']);
    Route::post('admin/faqs', ['as' => 'admin.faqs.store', 'uses' => 'Admin\FaqsController@store']);
    Route::get('admin/faqs/create', ['as' => 'admin.faqs.create', 'uses' => 'Admin\FaqsController@create']);
    Route::put('admin/faqs/{faqs}', ['as' => 'admin.faqs.update', 'uses' => 'Admin\FaqsController@update']);
    Route::patch('admin/faqs/{faqs}', ['as' => 'admin.faqs.update', 'uses' => 'Admin\FaqsController@update']);
    Route::delete('admin/faqs/{faqs}', ['as' => 'admin.faqs.destroy', 'uses' => 'Admin\FaqsController@destroy']);
    Route::get('admin/faqs/{faqs}', ['as' => 'admin.faqs.show', 'uses' => 'Admin\FaqsController@show']);
    Route::get('admin/faqs/{faqs}/edit', ['as' => 'admin.faqs.edit', 'uses' => 'Admin\FaqsController@edit']);


});



