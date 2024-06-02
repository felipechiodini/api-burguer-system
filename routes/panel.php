<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('forgot-password', 'UserController@sendMailForgetPassword');
    Route::get('me', 'AuthController@me');
});

Route::post('user', 'UserController@store');

Route::middleware('auth:api')
    ->group(function() {
        Route::post('broadcast/auth', 'AuthController@websocket');
        Route::get('stores', 'StoreController@all');
        Route::post('store', 'StoreController@store');
        Route::get('notification', 'NotificationController@index');
        Route::post('notification/{notification}/read', 'NotificationController@markAsRead');
        Route::get('notification/unread-count', 'NotificationController@unreadMessages');
    });

Route::middleware('auth:api')
    ->middleware('tenant')
    ->prefix('{tenant}')
    ->group(function() {
        Route::get('dashboard', 'DashboardController@get');
        Route::get('store', 'StoreController@get');
        Route::put('store', 'StoreController@update');
        Route::get('sidebar', 'SideBarController@get');
        Route::get('address', 'StoreAddressController@get');
        Route::post('address', 'StoreAddressController@updateOrCreate');
        Route::get('schedule', 'StoreScheduleController@get');
        Route::post('schedule', 'StoreScheduleController@createOrUpdate');
        Route::get('configuration', 'StoreConfigurationController@get');
        Route::post('configuration', 'StoreConfigurationController@updateOrCreate');
        Route::get('category/all', 'CategoryController@all');
        Route::get('payment', 'PaymentController@index');
        Route::post('payment/{key}/status', 'PaymentController@status');
        Route::get('delivery', 'DeliveryController@index');
        Route::post('delivery/{type}/active', 'DeliveryController@active');
        Route::apiResource('category', 'CategoryController');
        Route::apiResource('customer', 'CustomerController');
        Route::apiResource('banner', 'BannerController');
        Route::apiResource('order', 'OrderController');
        Route::apiResource('product', 'ProductController');
        Route::apiResource('product/{product}/photo', 'ProductPhotoController');
        Route::apiResource('product/{product}/prices', 'ProductPriceController');
        Route::apiResource('product/{product}/additionals', 'ProductAdditionalController');
        Route::apiResource('product/{product}/replacements', 'ProductReplacementController');
        Route::get('product/{product}/configuration', 'ProductConfigurationController@get');
        Route::post('product/{product}/configuration', 'ProductConfigurationController@createOrUpdate');
        Route::apiResource('combo', 'ComboController');
        Route::apiResource('combo/{combo}/option', 'ComboOptionController');
        Route::apiResource('card', 'CardController');
        Route::apiResource('waiter', 'WaiterController');
        Route::get('order-manager', 'OrderManagerController@index');
        Route::get('order-manager/{order}', 'OrderManagerController@show');
        Route::post('order-manager/{order}/confirm', 'OrderManagerController@confirm');
        Route::post('order-manager/{order}/dispatch', 'OrderManagerController@dispatchOrder');
        Route::post('order-manager/{order}/cancel', 'OrderManagerController@cancel');
    });


