<?php

namespace App\Shop\Cart\Discounts;

use App\Models\Product;
use App\Models\Payment;
use App\Models\Promocode as PromocodeModel;
use App\Shop\Exceptions\InvalidPromocodeException;
use Session;
use Cart;

class Promocode
{
    private $model;
    public $promocode;
    public $products;

    public function __construct(PromocodeModel $model)
    {
        $this->model = $model;  
        $this->products = Cart::products();      
    }

    public function get()
    {    
        if ($this->promocode != null) {
    
            $this->clearIfUsed($this->promocode->title);
			return $this->promocode;
		}

        $this->promocode = Session::has('promocode') 
            ? Session::get('promocode') 
            : new PromocodeModel();

        return $this->promocode;
    }

    public function set($promocode)
    {
        $promocodeItem = $this->model->getByTitle($promocode);

        if (empty($promocodeItem)) {
            throw new InvalidPromocodeException("Invalid or used promo code");
        }

        if (!$promocodeItem->is_once) {
            $currentDate = date('Y-m-d');
            if (!($currentDate >= $promocodeItem->date_start && $currentDate <= $promocodeItem->date_end)) {
                throw new InvalidPromocodeException("Promocode is expired");
            }
        }
 
        Session::put('promocode', $promocodeItem);
        $this->promocode = $promocodeItem;

        return $this->promocode;
    }

    public function getIsFreeDelivery()
    {
        return $this->get()->is_free_delivery;
    }

    public function getDiscount() {

        if (empty($this->get())) {
            return 0;
        }

        $products = $this->products;

        $idProductsPromocode = $this->getProductsIds();

        $promocodeDiscount = 0;
        foreach ($products as $product) {
            if (in_array($product->id, $idProductsPromocode)) {
                $promocodeDiscount += $this->getValue($product->price, $product->qty);
            }
        }

        return $promocodeDiscount;
    }

    public function getValue($value, $qty)
    {
        $promocode = $this->get();

        if ($promocode->symbol == 'money') {
            return $qty * $promocode->value;
        } else if ($promocode->symbol == 'percent') {
            return $value * $qty * $promocode->value / 100;
        }

        return 0;
    }

    public function getProductsIds()
    {
        $productsIdsByCategories = $this->getCategoriesProductsIds();

        $productsIds = $this->get()->getProductsIds();

        return array_merge($productsIds, $productsIdsByCategories);
    }

    private function getCategoriesProductsIds()
    {
        $categoriesIds = $this->get()->getCategoriesIds();

        return Product::select('id')
        ->when(!empty($categoriesIds), function($q) use ($categoriesIds) {
            $q->whereIn('id_categories', $categoriesIds);
        }) 
        ->whereIn('id', $this->products->pluck('id'))
        ->get()->pluck('id')->all();
    }

    private function clearIfUsed($value)
    {
        $promocodeItem = $this->model->getByTitle($value);
            
        if (empty($promocodeItem)) {
            $this->clear();
        }
    }

    public function setUsed()
    {
        if ($this->promocode->is_once) {
            $promocode = $this->model->where('id', $this->promocode->id)->first();
            $promocode->is_used = 1;
            $promocode->save();
        }

        $this->clear();
    }

    public function clear()
    {
        $this->promocode = new PromocodeModel();
        Session::remove('promocode');
    }
}