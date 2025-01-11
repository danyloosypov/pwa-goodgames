<?php

namespace App\View\Components\Checkout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use CartPrice;

class Info extends Component
{
    public $subtotal;
    public $total;

    public function __construct()
    {
        $this->total = CartPrice::total();
        $this->subtotal = CartPrice::subtotal();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkout.info', [
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ])->render();
    }
}
