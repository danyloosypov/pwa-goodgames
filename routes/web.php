<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::group([
	'prefix' => Lang::prefix(),
	'middleware' => [
		\App\FastAdminPanel\Middleware\Convertor::class,
		//\App\FastAdminPanel\Middleware\RedirectSEO::class,
	]
], function(){

	Route::get('/', [PageController::class, 'index']);
	Route::get('/blog', [BlogController::class, 'index'])->name('blog');
	Route::get('/blog/{article:slug}', [BlogController::class, 'show'])->name('article');

	Route::fallback(function () {
        return view("errors.404");
    });
});