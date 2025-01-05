<?php

namespace App\View\Components\Index;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product;

class BestSelling extends Component
{
    public $bestSellingProducts;

    public function __construct()
    {
        $this->bestSellingProducts = Product::withCount('orderProducts')
            ->orderBy('order_products_count', 'desc') // Sort by the order count
            ->take(4) // Get only the top 4 products
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.index.best-selling');
    }
}
