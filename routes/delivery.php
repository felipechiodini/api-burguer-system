<?php

use Illuminate\Support\Facades\Route;

Route::middleware('tenant')
    ->prefix('{tenant}')
    ->group(function() {
        Route::get('store', App\Http\Controllers\Delivery\DataStore::class);
        Route::get('distance', 'StoreController@distance');
        Route::get('products', 'ProductController@get');
        Route::get('product/{product}', 'ProductController@show');
        Route::post('order/place', App\Http\Controllers\Delivery\PlaceOrder::class);
    });
