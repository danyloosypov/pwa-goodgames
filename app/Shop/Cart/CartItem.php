<?php

namespace App\Shop\Cart;

class CartItem
{
	public $id;
	public $qty;
	public $meta;
	
	public function __construct($id, $qty, $meta)
	{
		$this->id = $id;
		$this->qty = $qty;
		$this->meta = $meta;
	}
}