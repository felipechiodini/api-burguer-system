<?php

use Illuminate\Support\Facades\Route;

Route::middleware('tenant')
    ->prefix('{tenant}')
    ->group(function() {
        Route::get('store', 'StoreController@get');
        Route::get('distance', 'StoreController@distance');
        Route::get('products', 'ProductController@get');
        Route::get('product/{product}', 'ProductController@show');
        Route::post('order/place', 'OrderController@create');
    });
