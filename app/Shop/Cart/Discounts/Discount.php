<?php

namespace App\Shop\Cart\Discounts;

use App\Models\Discount as DiscountModel;
use CartPrice;

class Discount
{
    private $model;
    private $discount;
    private $isFreeDelivery;
    private $cartPrice;

    public function __construct(DiscountModel $model)
    {
        $this->model = $model;  
        $this->cartPrice = CartPrice::subtotal();   
        $this->init();
    }

    public function get()
    {    
        return $this->discount;
    }

    public function getIsFreeDelivery()
    {
        return $this->isFreeDelivery;
    }

    public function init()
    {
        $discounts = $this->model->where('money', '<=', $this->cartPrice)->get();

        $maxDiscount = $discounts->max('money');
        $this->discount = $discounts->firstWhere('money', $maxDiscount);
        $this->isFreeDelivery = $discounts->contains('is_free_delivery', 1);
    }

    public function getDiscount()
    {
        if (!$this->discount) {
            return 0;
        }

        $symbol = $this->discount->symbol;
        $value = $this->discount->value;

        if ($symbol == 'money') {
            return $value;
        } else if ($symbol == 'percent') {
            return $this->cartPrice * $value / 100;
        }

        return 0;
    }
}