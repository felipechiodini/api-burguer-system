<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['message' => 'Serviço não encontrado!'], 404);
});
