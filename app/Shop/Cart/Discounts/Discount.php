<?php

namespace App\Shop\Cart\Discounts;

use App\Models\CartDiscount as DiscountModel;
use CartPrice;

class Discount
{
    private $model;
    private $discount;
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

    public function init()
    {
        $discounts = $this->model->where('money', '<=', $this->cartPrice)->get();

        $maxDiscount = $discounts->max('money');
        $this->discount = $discounts->firstWhere('money', $maxDiscount);
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