<?php

namespace App\Shop\Cart\Storage;

use Illuminate\Support\Collection;
use App\Shop\Cart\Storage\StorageInterface;
use Session;

class SessionStorage implements StorageInterface
{
    public function get()
    {
        $cart = Session::has('cart') 
            ? Session::get('cart') 
            : new Collection();
		
        return $cart;
	}

	public function set($cartProducts)
    {
		Session::put('cart', $cartProducts);
	}

    public function clear()
    {
        Session::remove('cart');
    }   
}