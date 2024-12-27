<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
	public function index($slug)
	{
		$product = Product::with(['genres', 'productCategories', 'productTags', 'platforms', 'reviews'])
		->where('slug', $slug)
		->firstOrFail();

		$relatedProducts = Product::whereHas('productCategories', function($query) use ($product) {
                $query->whereIn('id_product_categories', $product->productCategories->pluck('id'));
            })
            ->where('id', '!=', $product->id) 
            ->limit(6)
            ->get();
		
        return view('pages.store.product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]); 
	}
}