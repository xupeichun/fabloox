<?php

/**
 * All route names are prefixed with 'admin.access'.
 */

//添加admin/access
Route::group([
    'prefix' => 'access',
    'as' => 'access.',
    'namespace' => 'Access',
], function () {


    Route::group([
        'middleware' => 'access.routeNeedsRole:1',
    ], function () {

        /*========category Managment======================*/
        Route::group(['namespace' => 'Category'], function () {
            Route::get('category/deactivated', 'CategoryTableController@deactivateView')->name('category.deactivated');
            Route::delete('category/deactivateCategory', 'CategoryTableController@deactivateCategory')->name('category.deactivateCategory');
            Route::get('category/activateCategory', 'CategoryTableController@activateCategory')->name('category.activateCategory');

            /*
             * Category CRUD
             */
            Route::resource('category', 'CategoryController');

            /*
             * For DataTables
            */

            Route::post('category/get', 'CategoryTableController@getAll')->name('category.get');
            Route::post('category/deactivate', 'CategoryTableController@allDeactvated')->name('category.deactivate');

        });


        /*========Brand Managment======================*/
        Route::group(['namespace' => 'Brand'], function () {
            Route::get('brand/deactivated', 'BrandTableController@deactivateView')->name('brand.deactivated');
            Route::delete('brand/deactivateCategory', 'BrandTableController@deactivateBrand')->name('brand.deactivateBrand');
            Route::get('brand/activateCategory', 'BrandTableController@activateBrand')->name('brand.activateBrand');

            /*
             * Brand CRUD
             */
            Route::resource('brand', 'BrandController');

            /*
             * For DataTables
            */

            Route::post('brand/get', 'BrandTableController@getAll')->name('brand.get');
            Route::post('brand/deactivate', 'BrandTableController@allDeactvated')->name('brand.deactivate');


            Route::post('brand/addlinks', 'BrandTableController@addVideoLinks')->name('brand.add.links');
            Route::get('brand/editlinks/{id}', 'BrandTableController@editVideoLinks');
            Route::post('brand/updatelinks', 'BrandTableController@updateVideoLinks')->name('brand.update.links');
            Route::post('brand/deletelinks', 'BrandTableController@deleteVideoLinks')->name('brand.delete.links');

        });

        /*========Product Managment======================*/
        Route::group(['namespace' => 'Product'], function () {
            Route::get('product/bestonfabloox', 'ProductTableController@showBestOnFabloox')->name('product.show.best');

            Route::get('product/viglink', 'ProductTableController@getIndex')->name('product.get.index2');

            Route::get('product/deactivated', 'ProductTableController@deactivateView')->name('product.deactivated');
            Route::post('product/deactivateproduct', 'ProductTableController@deactivateProduct')->name('product.deactivate');
            Route::get('product/activateItem', 'ProductTableController@activateItem')->name('product.activateItem');

            /*
             * Product CRUD
             */
            Route::resource('product', 'ProductController');

            /*
             * For DataTables
            */

            //Route::post('influencer/get', 'InfluencerTableController@getAll')->name('influencer.get');
            Route::post('product/deactivate', 'ProductTableController@allDeactvated')->name('product.all.deactivate');

            Route::post('product/addlinks', 'ProductTableController@addVideoLinks')->name('product.add.links');
            Route::get('product/editlinks/{id}', 'ProductTableController@editVideoLinks')->name('product.edit.links');
            Route::post('product/updatelinks', 'ProductTableController@updateVideoLinks')->name('product.update.links');
            Route::post('product/deletelinks', 'ProductTableController@deleteVideoLinks')->name('product.delete.links');
            /*================add best on fabloox=========================*/
            Route::post('product/addbest', 'ProductTableController@addBestOnFabloox')->name('product.add.best');
            /*================return best on fabloox=========================*/
            /*================remove best on fabloox=========================*/
            Route::post('product/removebest', 'ProductTableController@removeBestOnFabloox')->name('product.remove.best');
            /*================add gallery products=========================*/
            Route::post('product/galleryproducts', 'ProductTableController@addGalleryProducts')->name('product.add.gallery.products');
        /*================show gallery products list=========================*/
            Route::get('product/galleryproducts/list', 'ProductTableController@viewGalleryProducts')->name('product.list.gallery.products');
            Route::post('product/remove-gallery-product', 'ProductTableController@removeGalleryProducts')->name('product.gallery.remove');

        });


        /*========influencer Managment======================*/
        Route::group(['namespace' => 'Influencer'], function () {
            Route::get('influencer/deactivated', 'InfluencerTableController@deactivateView')->name('influencer.deactivated');
            Route::delete('influencer/deactivateItem', 'InfluencerTableController@deactivateItem')->name('influencer.deactivateItem');
            Route::get('influencer/activateItem', 'InfluencerTableController@activateItem')->name('influencer.activateItem');

            /*
             * influencer CRUD
             */
            Route::resource('influencer', 'InfluencerController');

            /*
             * For DataTables
            */

            Route::post('influencer/get', 'InfluencerTableController@getAll')->name('influencer.get');
            Route::post('influencer/deactivate', 'InfluencerTableController@allDeactvated')->name('influencer.all.deactivate');

            Route::post('influencer/addlinks', 'InfluencerTableController@addVideoLinks')->name('influencer.add.links');
            Route::get('influencer/editlinks/{id}', 'InfluencerTableController@editVideoLinks');
            Route::post('influencer/updatelinks', 'InfluencerTableController@updateVideoLinks')->name('influencer.update.links');
            Route::post('influencer/deletelinks', 'InfluencerTableController@deleteVideoLinks')->name('influencer.delete.links');

        });

        /*========HomepageVideo Managment======================*/
        Route::group(['namespace' => 'HomepageVideo'], function () {
            Route::get('homepagevideo/deactivated', 'HomepageVideoTableController@deactivateView')->name('homepagevideo.deactivated');
            Route::delete('homepagevideo/deactivateItem', 'HomepageVideoTableController@deactivateItem')->name('homepagevideo.deactivateItem');
            Route::get('homepagevideo/activateItem', 'HomepageVideoTableController@activateItem')->name('homepagevideo.activateItem');

            /*
             * HomepageVideo CRUD
             */
            Route::resource('homepagevideo', 'HomepageVideoController');

            /*
             * For DataTables
            */

            Route::post('homepagevideo/get', 'HomepageVideoTableController@getAll')->name('homepagevideo.get');
            Route::post('homepagevideo/deactivate', 'HomepageVideoTableController@allDeactvated')->name('homepagevideo.all.deactivate');

        });

        /*========Gallery Managment======================*/
        Route::group(['namespace' => 'Gallery'], function () {
            Route::get('gallery/deactivated', 'GalleryTableController@deactivateView')->name('gallery.deactivated');
            Route::delete('gallery/deactivateItem', 'GalleryTableController@deactivateItem')->name('gallery.deactivateItem');
            Route::get('gallery/activateItem', 'GalleryTableController@activateItem')->name('gallery.activateItem');

            /*
             * HomepageVideo CRUD
             */
            Route::resource('gallery', 'GalleryController');

            /*
             * For DataTables
            */

            Route::post('gallery/get', 'GalleryTableController@getAll')->name('gallery.get');
            Route::post('gallery/deactivate', 'GalleryTableController@allDeactvated')->name('gallery.all.deactivate');

        });
        /*
        * Role Management
        */
        Route::group(['namespace' => 'Role'], function () {
            Route::resource('role', 'RoleController', ['except' => ['show']]);

            //For DataTables
            Route::post('role/get', 'RoleTableController')->name('role.get');
        });
    });
    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsRole:1',
    ], function () {
        Route::group(['namespace' => 'User'], function () {
            /*
             * For DataTables
             */
            Route::post('user/get', 'UserTableController')->name('user.get');

            /*
             * User Status'
             */
            Route::get('user/deactivated', 'UserStatusController@getDeactivated')->name('user.deactivated');
            Route::get('user/deleted', 'UserStatusController@getDeleted')->name('user.deleted');

            /*
             * User CRUD
             */
            Route::resource('user', 'UserController');

            /*
             * Content CRUD
             */
            /* Policy route*/
            Route::get('content/policy', 'ContentManagementController@viewPolicy')->name('content.policy');
            Route::post('content/addPolicy', 'ContentManagementController@addPolicy')->name('content.addPolicy');
            /* terms route*/
            Route::get('content/terms', 'ContentManagementController@viewTerms')->name('content.terms');
            Route::post('content/addTerms', 'ContentManagementController@addTerms')->name('content.addTerms');
            /* Faqs route*/
            Route::get('content/faqs', 'ContentManagementController@viewFaqs')->name('content.faqs');
            Route::post('content/addFaqs', 'ContentManagementController@addFaqs')->name('content.addFaqs');
            /* Help route*/
            Route::get('content/info', 'ContentManagementController@viewInfo')->name('content.info');
            Route::post('content/addInfo', 'ContentManagementController@addInfo')->name('content.addInfo');
            /* About route*/
            Route::get('content/about', 'ContentManagementController@viewAbout')->name('content.about');
            Route::post('content/addAbout', 'ContentManagementController@addAbout')->name('content.addAbout');


            /*
             * Specific User
             */
            Route::group(['prefix' => 'user/{user}'], function () {
                // Account
                Route::get('account/confirm/resend', 'UserConfirmationController@sendConfirmationEmail')->name('user.account.confirm.resend');

                // Status
                Route::get('mark/{status}', 'UserStatusController@mark')->name('user.mark')->where(['status' => '[0,1]']);

                // Password
                Route::get('password/change', 'UserPasswordController@edit')->name('user.change-password');
                Route::patch('password/change', 'UserPasswordController@update')->name('user.change-password.post');

                // Access
                Route::get('login-as', 'UserAccessController@loginAs')->name('user.login-as');

                // Session
                Route::get('clear-session', 'UserSessionController@clearSession')->name('user.clear-session');
            });

            /*
             * Deleted User
             */
            Route::group(['prefix' => 'user/{deletedUser}'], function () {
                Route::get('delete', 'UserStatusController@delete')->name('user.delete-permanently');
                Route::get('restore', 'UserStatusController@restore')->name('user.restore');
            });
        });

        /*
        * Role Management
        */
        Route::group(['namespace' => 'Role'], function () {
            Route::resource('role', 'RoleController', ['except' => ['show']]);

            //For DataTables
            Route::post('role/get', 'RoleTableController')->name('role.get');
        });


    });
});

