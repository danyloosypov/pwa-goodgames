<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(base_path('routes/api_v1/api_v1.php'));
Route::prefix('v2')->group(base_path('routes/api_v2/api_v2.php'));