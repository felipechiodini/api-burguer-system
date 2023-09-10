<?php

use Illuminate\Support\Facades\Route;

Route::get('store', 'StoreController@get');

Route::middleware('tenant')->group(function() {
    Route::get('products', 'ProductController@index');
    Route::get('product/{product}', 'ProductController@show');
    Route::get('distance', 'StoreController@distance');
    Route::get('shipping/calculate', 'DeliveryController@calculateShipping');
    Route::post('cart/finish', 'OrderController@create');
});
