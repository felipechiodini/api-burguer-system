<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'SiteController@index');
Route::get('/planos-e-precos', 'SiteController@plansPrices');
Route::get('/login', 'LoginController@get');
Route::post('/login', 'LoginController@login');
