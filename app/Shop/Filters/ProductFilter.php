<?php

namespace App\Shop\Filters;

use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;

class ProductFilter extends AbstractFilter
{
    protected $filters = [
        'categories'    => Category::class,
        'brand'         => Brand::class,
    ];

    protected $sort = ['price', 'viewed', 'rating'];

    protected $model = Product::class;
}