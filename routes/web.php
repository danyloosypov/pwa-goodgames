<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TournamentCotroller;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;

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

	Route::get('/', [PageController::class, 'index'])->name('home');
	Route::get('/blog', [BlogController::class, 'index'])->name('blog');
	Route::get('/blog/{article:slug}', [BlogController::class, 'show'])->name('article');

	Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
	Route::get('/product/{product:slug}', [ProductController::class, 'index'])->name('product');

	Route::get('/tournaments', [TournamentCotroller::class, 'index'])->name('tournaments');
	Route::get('/tournaments/{tournament:slug}', [TournamentCotroller::class, 'show'])->name('tournament');
	Route::get('/tournaments/{tournament:slug}/teams', [TournamentCotroller::class, 'teams'])->name('teams');
	Route::get('/teams/{teammate:slug}', [TournamentCotroller::class, 'teammate'])->name('teammate');

	Route::fallback(function () {
        return view("errors.404");
    });
});