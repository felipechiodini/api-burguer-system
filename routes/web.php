<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'CompanyController@index');
Route::get('/planos-e-precos', 'CompanyController@plansPrices');
