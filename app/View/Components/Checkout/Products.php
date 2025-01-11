<?php

namespace App\View\Components\Checkout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Cart;

class Products extends Component
{
    public $products;

    public function __construct()
    {
       $this->products = Cart::products();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkout.products', [
            'products' => $this->products,
        ])->render();
    }
}
