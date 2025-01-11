<?php

namespace App\Shop\Cart;

use App\Shop\Cart\Storage\SessionStorage;
use App\Shop\Cart\Storage\StorageInterface;
use App\Models\Product;
use Illuminate\Support\Collection;

class Cart
{
    private $storage;
    private $cartItems;
    private $products;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
        $this->mergeCarts();
    }

    public function add($id, $qty, $meta = '')
    {
		$cartItems = $this->getItems();

        $cartItem = $cartItems->where('id', $id)
        ->where('meta', $meta)
        ->first();
        
        if (empty($cartItem)) {

            $cartItems = $cartItems->add(new CartItem($id, $qty, $meta ?? ''));

        } else {
            if ($qty < 0)
                $cartItem->qty += $qty;
            
            $cartItem->meta = $meta;

            if ($cartItem->qty <= 0) {
                $cartItems = $cartItems->reject(function($item, $key) use ($id, $meta){
                    return $item->id == $id && $item->meta == $meta;
                });
            }
        }

        $this->storage->set($cartItems);
	}

    public function products()
    {
		if (!empty($this->products)) {
			return $this->products;
		}

		$cartItems = $this->getItems();

		$products = Product::whereIn('id', $cartItems->pluck('id'))
		->get();

        $items = new Collection();

        foreach ($cartItems as $cartItem) {

            $product = clone $products->where('id', $cartItem->id)->first();
            $product->qty = $cartItem->qty;
            $product->meta = $cartItem->meta;
            $product->price = $product->price;

            $items = $items->push($product);
        }

		$this->products = $items;

		return $this->products;
	}

    public function count()
    {
		return $this->getItems()->sum('qty');
	}

    public function getItems()
    {
        if (!empty($this->cartItems)) {
            return $this->cartItems;
        }

        $cartItems = $this->storage->get();
        $issetProductsIds = Product::select('id')
        ->whereIn('id', $cartItems->pluck('id'))
        ->get()->pluck('id');

        $cartItems = $cartItems->filter(function($cartItem) use ($issetProductsIds) {
            return $issetProductsIds->contains($cartItem->id);
        });
        
        if (count($cartItems->pluck('id')) < count($issetProductsIds)) {
            $this->storage->set($cartItems);
        }

		return $cartItems;
	}

    public function clear ()
    {
		$this->storage->clear();
	}

    private function mergeCarts()
    {
        if ($this->storage instanceof SessionStorage) {
            return;
        }

        $sessionStorage = new SessionStorage();
		$sessionCart = $sessionStorage->get();

		if ($sessionCart->isNotEmpty()) {

			$cart = $this->storage->get();

            $cart = $cart->reject(function ($cartItem) use ($sessionCart) {
                return $sessionCart->contains('id', $cartItem->id);
            });

            $this->storage->set(
                $cart->merge($sessionCart)
            );

			$sessionStorage->clear();
		}
    }
}