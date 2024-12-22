<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class Catalog extends Component
{
    use WithPagination;

    public $platform;
    public $genres = [];
    public $categories = [];
    public $minPrice;
    public $maxPrice;

    protected $queryString = [
        'platform' => ['except' => ''],
        'genres' => ['except' => []],
        'categories' => ['except' => []],
        'minPrice' => ['except' => null],
        'maxPrice' => ['except' => null],
    ];

    public function mount(Request $request)
    {
        $this->platform = $request->query('platform', '');
        $this->genres = $request->query('genres', []);
        $this->categories = $request->query('categories', []);
        $this->minPrice = $request->query('minPrice', null);
        $this->maxPrice = $request->query('maxPrice', null);
    }

    public function render()
    {
        $platforms = Platform::all();
        $categoriesCollection = ProductCategory::all();
        $genresCollection = Genre::all();
    
        $query = Product::query()
            ->when($this->platform, function ($query) {
                $query->whereHas('platforms', function ($query) {
                    $query->where('id_platforms', $this->platform);
                });
            })
            ->when($this->genres, function ($query) {
                $query->whereHas('genres', function ($query) {
                    $query->whereIn('id_genres', $this->genres);
                });
            })
            ->when($this->categories, function ($query) {
                $query->whereHas('productCategories', function ($query) {
                    $query->whereIn('id_product_categories', $this->categories);
                });
            })
            ->when($this->minPrice, function ($query) {
                $query->where('price', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function ($query) {
                $query->where('price', '<=', $this->maxPrice);
            });
    
        $minPriceValue = $query->min('price');
        $maxPriceValue = $query->max('price');
    
        $products = $query->paginate(16);
    
        return view('livewire.catalog', [
            'products' => $products,
            'categoriesCollection' => $categoriesCollection,
            'genresCollection' => $genresCollection,
            'platforms' => $platforms,
            'minPriceValue' => $minPriceValue,
            'maxPriceValue' => $maxPriceValue,
        ]);
    }
    
    public function updatePrice($priceRange)
    {
        $this->minPrice = $priceRange[0];
        $this->maxPrice = $priceRange[1];
    
        $this->resetPage();
    }

    public function updateGenres($genre)
    {
        if (in_array($genre, $this->genres)) {
            $this->genres = array_diff($this->genres, [$genre]);
        } else {
            $this->genres[] = $genre;
        }

        $this->resetPage();
    }

    public function updateCategories($category)
    {
        if (in_array($category, $this->categories)) {
            $this->categories = array_diff($this->categories, [$category]);
        } else {
            $this->categories[] = $category;
        }

        $this->resetPage();
    }

    public function updatePlatform($platformId)
    {
        $this->platform = $this->platform == $platformId ? '' : $platformId;
        $this->resetPage(); 
    }

    public function paginationView()
    {
        return 'custom-pagination-links-view';
    }
}
