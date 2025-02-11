<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\ProductCategory;

class CatalogController extends Controller
{
	public function index(Request $request)
	{
        return view('pages.store.catalog'); 
	}

	public function offline(Request $request)
	{
        $products = Product::all();

        return view('pages.store.catalog-offline', [
            'products' => $products,
        ]); 
	}
}