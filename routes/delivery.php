<?php

use Illuminate\Support\Facades\Route;

Route::get('store', 'StoreController@get');

Route::middleware('delivery.store')->group(function() {
    Route::apiResource('product', 'ProductController');
    Route::get('distance', 'StoreController@distance');
    Route::get('shipping', 'ShippingController@value');
    Route::apiResource('order', 'OrderController');
    Route::post('cart/add-item', 'CartController@addItem');
    Route::post('cart/remove-item', 'CartController@addItem');
});
