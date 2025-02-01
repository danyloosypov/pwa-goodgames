<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TournamentCotroller;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/clear_cache', function () {
    // Clear application cache
    Artisan::call('cache:clear');
    
    // Clear route cache
    Artisan::call('route:clear');
    
    // Clear config cache
    Artisan::call('config:clear');
    
    // Clear view cache
    Artisan::call('view:clear');

    return response()->json(['message' => 'All caches cleared successfully']);
});

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::group([
	'prefix' => Lang::prefix(),
	'middleware' => [
		\App\FastAdminPanel\Middleware\Convertor::class,
		//\App\FastAdminPanel\Middleware\RedirectSEO::class,
	]
], function(){
	Route::any('/api/handle-payment-callback', [CheckoutController::class, 'handlePaymentCallback'])->name('handle-payment-callback');

	Route::post('/api/logout', [AuthController::class, 'logout'])->name('api-logout');
	Route::post('/api/send-checkout', [CheckoutController::class, 'send'])->name('api-send-checkout');
	Route::post('/api/user-edit', [AccountController::class, 'editUser'])->name('api-user-edit');
	Route::post('/api/add-to-cart', [CartController::class, 'add'])->name('api-add-to-cart');
	Route::post('/api/set-promocode', [CartController::class, 'setPromocode'])->name('api-set-promocode');
	Route::post('/api/subtract-points', [CartController::class, 'subtractPoints'])->name('api-subtract-points');
	Route::post('/api/send-checkout', [CheckoutController::class, 'send'])->name('api-send-checkout');
	Route::post('/api/change-payment', [CheckoutController::class, 'changePayment'])->name('api-change-payment');

	Route::get('/', [PageController::class, 'index'])->name('home');

	Route::get('/account', [AccountController::class, 'account'])->name('account');

	Route::get('/blog', [BlogController::class, 'index'])->name('blog');
	Route::get('/blog/{article:slug}', [BlogController::class, 'show'])->name('article');

	Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
	Route::get('/catalog-offline', [CatalogController::class, 'offline'])->name('catalog-offline');
	Route::get('/product/{product:slug}', [ProductController::class, 'index'])->name('product');

	Route::get('/tournaments', [TournamentCotroller::class, 'index'])->name('tournaments');
	Route::get('/tournaments/{tournament:slug}', [TournamentCotroller::class, 'show'])->name('tournament');
	Route::get('/teammates/{teammate:slug}', [TournamentCotroller::class, 'teammate'])->name('teammate');

	Route::get('/checkout', [CheckoutController::class, 'page'])->name('checkout');
	
	Route::get('/thanks/paypal', [CheckoutController::class, 'thanks'])->name('thanks.paypal');
	Route::get('/thanks', [CheckoutController::class, 'thanks'])->name('thanks')->middleware('signed');
	
	Route::fallback(function () {
        return view("errors.404");
    });
});
/*
Route::get('/offline', function () {
	return view('modules/laravelpwa/offline');
});*/