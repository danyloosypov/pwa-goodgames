<?php

namespace App\View\Components\Cart;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Cart;

class Items extends Component
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
        return view('components.cart.items', [
            'products' => $this->products,
        ])->render();
    }
}
