<?php

namespace App\Shop\Cart\Storage;

use Illuminate\Support\Collection;
use App\Shop\Cart\CartItem;
use App\Shop\Cart\Storage\StorageInterface;
use App\Models\Cart as CartModel;
use Auth;

class DatabaseStorage implements StorageInterface
{

    private $user;
    private $model;

	public function __construct (CartModel $model)
    {
		$this->user = Auth::user();
        $this->model = $model;
	}
    
    public function get()
    {
        $cartItems = $this->model
        ->select('id_products AS id', 'qty', 'meta')
		->where('id_users', $this->user->id)
		->get();

        $cart = new Collection();
        foreach ($cartItems as $cartItem) {
            $cart = $cart->add(new CartItem($cartItem->id, $cartItem->qty, $cartItem->meta));
        }

		return $cart;
	}

	public function set($cartItems)
    {
        $this->clear();

        foreach ($cartItems as $cartItem) {
			
            $cart = new $this->model([
                'id_users'      => $this->user->id,
                'id_products'   => $cartItem->id,
                'qty'           => $cartItem->qty,
                'meta'          => $cartItem->meta ?? '',
            ]);

            $cart->save();
		}
	}

    public function clear()
    {
        $this->model
        ->where('id_users', $this->user->id)
		->delete();
    }

}