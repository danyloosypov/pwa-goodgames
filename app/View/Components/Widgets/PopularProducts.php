<?php

namespace App\View\Components\Widgets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product;

class PopularProducts extends Component
{
    public $products;

    public function __construct()
    {
        $this->products = Product::withAvg('reviews', 'rating')
        ->having('reviews_avg_rating', '>=', 4)  // Filter products with rating 4 or higher
        ->inRandomOrder()
        ->limit(3)
        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.popular-products');
    }
}
