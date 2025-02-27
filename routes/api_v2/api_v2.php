<?php
 
use App\Http\Controllers\Api\V2\ArticlesController;
 
Route::apiResource('articles', ArticlesController::class);