<?php

namespace App\Shop;

use Illuminate\Support\ServiceProvider;
use App\Shop\Cart\Storage\DatabaseStorage;
use App\Shop\Cart\Storage\SessionStorage;
use App\Shop\Cart\Storage\StorageInterface;
use Auth;
use Illuminate\Foundation\AliasLoader;

class ShopServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StorageInterface::class, function () {
            if (Auth::check()) {
                return resolve(DatabaseStorage::class);
            } else {
                return resolve(SessionStorage::class);
            }
        });

        $this->app->singleton('cart', \App\Shop\Cart\Cart::class);
        $this->app->singleton('cart_price', \App\Shop\Cart\CartPrice::class);
        $this->app->singleton('saved', \App\Shop\Saved\Saved::class);
        $this->app->singleton('promocode', \App\Shop\Cart\Discounts\Promocode::class);
        $this->app->singleton('discount', \App\Shop\Cart\Discounts\Discount::class);
        $this->app->singleton('user_discount', \App\Shop\Cart\Discounts\UserDiscount::class);
        $this->app->singleton('compare', \App\Shop\Compare\Compare::class);

        $this->app->booting(function() {

			$loader = AliasLoader::getInstance();

			$loader->alias('Cart',		\App\Shop\Facades\Cart::class);
			$loader->alias('CartPrice',		\App\Shop\Facades\CartPrice::class);
			$loader->alias('Saved',			\App\Shop\Facades\Saved::class);
			$loader->alias('Promocode',	\App\Shop\Facades\Promocode::class);
			$loader->alias('Discount',		\App\Shop\Facades\Discount::class);
			$loader->alias('UserDiscount',		\App\Shop\Facades\UserDiscount::class);
			$loader->alias('Compare',		\App\Shop\Facades\Compare::class);
		});
    }
}