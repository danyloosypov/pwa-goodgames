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
		$platforms = Platform::all();
        $categoriesCollection = ProductCategory::all();
        $genresCollection = Genre::all();

		$platform = $request->query('platform', '');
        $genres = $request->query('genres', []);
        $categories = $request->query('categories', []);
        $minPrice = $request->query('minPrice', null);
        $maxPrice = $request->query('maxPrice', null);
    
        $query = Product::query()
			->when($platform, function ($query) use ($platform) {
				// Use $platform within the closure to filter by platform
				$query->whereHas('platforms', function ($query) use ($platform) {
					$query->where('id_platforms', $platform);
				});
			})
			->when(!empty($genres), function ($query) use ($genres) {
				// Use $genres array within the closure to filter by genres
				$query->whereHas('genres', function ($query) use ($genres) {
					$query->whereIn('id_genres', $genres);
				});
			})
			->when(!empty($categories), function ($query) use ($categories) {
				// Use $categories array within the closure to filter by categories
				$query->whereHas('productCategories', function ($query) use ($categories) {
					$query->whereIn('id_product_categories', $categories);
				});
			})
			->when($minPrice, function ($query) use ($minPrice) {
				$query->where('price', '>=', $minPrice);
			})
			->when($maxPrice, function ($query) use ($maxPrice) {
				$query->where('price', '<=', $maxPrice);
			});

    
        $minPriceValue = $query->min('price');
        $maxPriceValue = $query->max('price');
    
        $products = $query->paginate(16);

        return view('pages.store.catalog-offline', [
            'products' => $products,
            'categoriesCollection' => $categoriesCollection,
            'genresCollection' => $genresCollection,
            'platforms' => $platforms,
            'minPriceValue' => $minPriceValue,
            'maxPriceValue' => $maxPriceValue,
			'platformActive' => $platform
        ]); 
	}
}