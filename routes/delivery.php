<?php

use Illuminate\Support\Facades\Route;

Route::get('store/{slug}', 'StoreController@get');
Route::get('distance', 'StoreController@distance');
Route::get('products', 'ProductController@get');
Route::get('product/{product}', 'ProductController@show');
Route::post('cart/finish', 'OrderController@create');
