<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

// Route::post('register', 'UserController@register');
// Route::delete('register', 'UserController@deleteAccount');
// Route::post('subscribe', 'UserController@subscribe');
Route::post('mail-reset-password', 'UserController@sendMailResetPassword');
Route::post('reset-password-token', 'UserController@resetPasswordByToken');

Route::get('store/all', 'UserStoreController@all');

Route::middleware(['tenant', 'auth:api'])->group(function() {
    Route::get('home', 'HomeController@get');
    Route::get('address', 'StoreAddressController@get');
    Route::post('address', 'StoreAddressController@updateOrCreate');
    Route::get('schedule', 'StoreScheduleController@get');
    Route::post('schedule', 'StoreScheduleController@createOrUpdate');
    Route::get('configuration', 'StoreConfigurationController@get');
    Route::post('configuration', 'StoreConfigurationController@updateOrCreate');
    Route::post('store/status', 'UserStoreController@setStatus');
    Route::get('category/all', 'CategoryController@all');
    Route::apiResource('category', 'CategoryController');
    Route::apiResource('banner', 'BannerController');
    Route::apiResource('order', 'OrderController');
    Route::post('product/{product}/configuration', 'ProductConfigurationController@createOrUpdate');
    Route::apiResource('product', 'ProductController');
    Route::apiResource('product/{product}/photo', 'ProductPhotoController');
    Route::apiResource('product/{product}/prices', 'ProductPriceController');
    Route::apiResource('product/{product}/additionals', 'ProductAdditionalController');
    Route::apiResource('product/{product}/replacements', 'ProductReplacementController');
    Route::apiResource('combo', 'ComboController');
    Route::apiResource('combo/{combo}/option', 'ComboOptionController');
    Route::apiResource('card', 'CardController');
    Route::apiResource('waiter', 'WaiterController');
    // Route::apiResource('combo/{combo}/product', 'ComboProductController');
    // Route::apiResource('order/{order}/sub-order', 'SubOrderController');
});
