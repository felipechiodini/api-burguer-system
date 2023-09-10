<?php

use Illuminate\Support\Facades\Route;

Route::middleware('tenant')->group(function() {
    Route::get('store', 'StoreController@get');
    Route::get('distance', 'StoreController@distance');
    Route::get('products', 'ProductController@index');
    Route::get('product/{product}', 'ProductController@show');
    Route::post('cart/finish', 'OrderController@create');
});
