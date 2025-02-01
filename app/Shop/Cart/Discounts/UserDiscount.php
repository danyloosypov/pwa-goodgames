<?php

namespace App\Shop\Cart\Discounts;

use Illuminate\Support\Collection;
use App\Models\Product;
use Session;
use Cart;
use Auth;

class UserDiscount
{
    private $products;
    private $bonusPoints;
    private $subtractPoints;

    public function __construct()
    {
        if (Auth::check()) {
            $this->bonusPoints = Auth::user()->points;
        } else {
            $this->bonusPoints = 0;
        }

        $this->subtractPoints = Session::get('subtract_points') ?? false;
        $this->products = Cart::products();      
    }

    public function setSubtractPoints($subtract)
    {
        Session::put('subtract_points', $subtract);
        $this->subtractPoints = $subtract;
    }

    public function getPoints()
    {
        return [$this->subtractPoints, $this->bonusPoints];
    }
}