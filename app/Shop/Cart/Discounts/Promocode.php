<?php

namespace App\Shop\Cart\Discounts;

use App\Models\Product;
use App\Models\Payment;
use App\Models\Promocode as PromocodeModel;
use App\Shop\Exceptions\InvalidPromocodeException;
use Carbon\Carbon;
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
            $currentDate = Carbon::today();

            if (!(Carbon::parse($promocodeItem->date_start) >= $currentDate && Carbon::parse($promocodeItem->date_end) >= $currentDate)) {
                throw new InvalidPromocodeException("Promocode is expired");
            }
        }
 
        Session::put('promocode', $promocodeItem);
        $this->promocode = $promocodeItem;

        return $this->promocode;
    }

    public function getDiscount() {
        if (empty($this->get())) {
            return 0;
        }
    
        $products = $this->products;
    
        $idProductsPromocode = $this->getProductsIds();
        $idProductsByCategories = $this->getCategoriesProductsIds();
        $idProductsByGenres = $this->getGenresProductsIds();
    
        $applyToAllProducts = empty($idProductsPromocode) && empty($idProductsByCategories) && empty($idProductsByGenres);
    
        $promocodeDiscount = 0;
        foreach ($products as $product) {
            if ($applyToAllProducts || in_array($product->id, array_merge($idProductsPromocode, $idProductsByCategories, $idProductsByGenres))) {
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
        return $this->get()->getProductsIds();
    }

    private function getCategoriesProductsIds()
    {
        $categoriesIds = $this->get()->getCategoriesIds();

        return Product::select('id')
            ->when(!empty($categoriesIds), function($q) use ($categoriesIds) {
                $q->whereHas('productCategories', function($q) use ($categoriesIds) {
                    $q->whereIn('id', $categoriesIds);
                });
            })
            ->whereIn('id', $this->products->pluck('id'))
            ->get()
            ->pluck('id')
            ->all();
    }

    private function getGenresProductsIds()
    {
        $genresIds = $this->get()->getGenresIds();

        return Product::select('id')
            ->when(!empty($genresIds), function($q) use ($genresIds) {
                $q->whereHas('genres', function($q) use ($genresIds) {
                    $q->whereIn('id', $genresIds);
                });
            })
            ->whereIn('id', $this->products->pluck('id'))
            ->get()
            ->pluck('id')
            ->all();
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
