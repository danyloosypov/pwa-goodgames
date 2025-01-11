<?php

namespace App\Shop\Cart\Discounts;

use Illuminate\Support\Collection;
use App\Models\Product;
use Cart;
use Auth;

class UserDiscount
{
    private $discounts;
    private $products;

    public function __construct()
    {
        if (Auth::check()) {
            $this->discounts = Auth::user()->discounts;
        } else {
            $this->discounts = new Collection();
        }

        $this->products = Cart::products();      
    }

    public function get()
    {    
        if ($this->discounts->isEmpty()) {
            return $this->discounts;
        }

        $products = Product::select('id')
        ->with('category')
        ->whereIn('id', $this->products->pluck('id'))
        ->get();

        foreach ($this->discounts as $discount) {
            $discount->id_products = $products->where('categories.id', $discount->id_categories)->pluck('id')->all();
        }

        return $this->discounts;
    }

    public function getDiscount()
    {
        if ($this->get()->isEmpty()) {
            return 0;
        }

        $userDiscount = 0;

        foreach ($this->get() as $discount) {

            foreach ($this->products as $product) {
                if (in_array($product->id, $discount->id_products)) {
                    $userDiscount += $this->getValue($discount, $product->price, $product->qty);
                }
            }
        }

        return $userDiscount;
    }

    public function getValue($discount, $value, $qty)
    {
        if ($discount->symbol == 'money') {
            return $discount->value;
        } else if ($discount->symbol == 'percent') {
            return $value * $qty * $discount->value / 100;
        }

        return 0;
    }
}