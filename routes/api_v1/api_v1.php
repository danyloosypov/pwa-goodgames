<?php
 
use App\Http\Controllers\Api\V1\ArticlesController;
 
Route::apiResource('articles', ArticlesController::class);