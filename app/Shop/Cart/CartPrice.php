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
        return Promocode::getDiscount();
    }

    public function discount() {
        return Discount::getDiscount();
    }

    public function userBonuses()
    {
        [$subtractPoints, $availableBonuses] = UserDiscount::getPoints();

        if ($subtractPoints) {
            return $availableBonuses;
        }

        return 0;
    }

    public function total($deliveryPrice = 0)
    {
        $subtotal = $this->subtotal();

        $promocodeDiscount = $this->promocode();
        $generalDiscount = $this->discount();
        $userBonuses = $this->userBonuses();

        $totalDiscount = $promocodeDiscount + $generalDiscount + $userBonuses;

        $maxAllowedDiscount = $subtotal * 0.5;
        if ($totalDiscount > $maxAllowedDiscount) {
            $totalDiscount = $maxAllowedDiscount;
        }

        return $subtotal - $totalDiscount + $deliveryPrice;
    }

    public function usedBonuses()
    {
        $subtotal = $this->subtotal();

        $promocodeDiscount = $this->promocode();
        $generalDiscount = $this->discount();
        $userBonuses = $this->userBonuses();

        $totalDiscount = $promocodeDiscount + $generalDiscount + $userBonuses;
        $maxAllowedDiscount = $subtotal * 0.5;

        if ($totalDiscount > $maxAllowedDiscount) {
            $totalDiscount = $maxAllowedDiscount;
        }

        $remainingDiscountAfterPromocodeAndGeneral = $totalDiscount - $promocodeDiscount - $generalDiscount;
        
        return $remainingDiscountAfterPromocodeAndGeneral > 0 ? min($remainingDiscountAfterPromocodeAndGeneral, $userBonuses) : 0;
    }
}