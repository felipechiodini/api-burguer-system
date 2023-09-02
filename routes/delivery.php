<?php

use Illuminate\Support\Facades\Route;

Route::get('store', 'StoreController@get');

// Route::middleware('delivery.store')->group(function() {
    Route::get('products', 'ProductController@index');
    Route::get('distance', 'StoreController@distance');
    Route::get('shipping', 'ShippingController@value');
    Route::post('cart/finish', 'CartController@finish');
// });
