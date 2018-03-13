<?php


Route::group(['namespace' => 'Favourite', 'as' => 'favourite.', 'middleware' => ['auth:api']], function () {
    Route::resource('favourites', 'FavouriteController', ['only' => ['index', 'store', 'destroy']]);
});