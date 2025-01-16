<?php

namespace App\View\Components\Inc;

use Single;
use Illuminate\View\Component;
use Cart;

class Header extends Component
{
    public $cartCount = 0;
    
    public function __construct()
	{
        $this->cartCount = Cart::count();
    }

    public function render(){
        return view('components.inc.header');
    }
}
