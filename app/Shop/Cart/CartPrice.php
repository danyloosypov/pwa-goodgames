<?php

namespace App\Shop\Cart;

use Discount;
use Promocode;
use UserDiscount;

class CartPrice
{
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function subtotal()
    {
		$subtotal = $this->cart->products()->map(function ($product, $key) {
            return $product->qty * $product->price;
        })->sum();

		return $subtotal;
	}

    public function promocode()
    {
        return 0;
        //return Promocode::getDiscount();
    }

    public function discount() {
        return 0;
        //return Discount::getDiscount();
    }

    public function userDiscount() {
        return 0;
        //return UserDiscount::getDiscount();
    }

    public function total()
    {
        return $this->subtotal() - $this->promocode() - $this->discount() - $this->userDiscount() ;
    }
}