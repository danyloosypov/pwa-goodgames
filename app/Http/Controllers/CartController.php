<?php

namespace App\Http\Controllers;

use App\FastAdminPanel\Helpers\Field;
use App\Http\Requests\CartAddRequest;
use App\Http\Requests\PromocodeRequest;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
//use App\Services\CheckoutService;
//use App\View\Components\Inc\Cart\CartInfo;
use App\View\Components\Cart\Items as CartProducts;
use App\View\Components\Checkout\Products as CheckoutProducts;
use App\View\Components\Checkout\Info as CheckoutInfo;
//use App\View\Components\Inc\Cart\Promocode as CartPromocode;
use Cart;
use CartPrice;
use Illuminate\Http\Request;
use Promocode;

class CartController extends Controller
{
	public function add(CartAddRequest $r)
	{
		$data = $r->validated();

		Cart::add($data['id_products'], $data['count'], $data['meta']);
		
		$cartProducts = new CartProducts();

		$cartCount = Cart::count();

		$product = Product::where('id', $data['id_products'])
		->first();

		if ($data['is_checkout']) {
			$checkoutProducts = new CheckoutProducts();
			$checkoutInfo = new CheckoutInfo();
			//$promocode = new CartPromocode(false);

			return response()->json([
				'minicart'			=> $cartProducts->render(),
				'checkout_products'				=> $checkoutProducts->render(),
				'checkout_info'			=> $checkoutInfo->render(),
				//'promocode'				=> $promocode->render(),
				//'payments'				=> $payments,
				'count'					=> $cartCount,
			]);
		}

		$product = Cart::products()->where('id', $data['id_products'])->first();

		return response()->json([
			'minicart'			=> $cartProducts->render(),
			'count'				=> $cartCount,
		]);
	}

	public function setPromocode(PromocodeRequest $r)
	{
		$data = $r->validated();

		$promocode = Promocode::set($data['promocode']);

		if (!$promocode) {
			return $this->error();
		}

		$cartInfo = new CartInfo(true);

		if ($data['is_checkout']) {

			$cartInfo = new CartInfo(false);

			return response()->json([
                'cart_info'             => $cartInfo->render(),
			]);
		}

		return response()->json([
			'cart_info'     => $cartInfo->render(),
		]);
	}
}