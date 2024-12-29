<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchComponent extends Component
{
    public $search = '';
    public $products = [];

    public function render()
    {
        $this->products = Product::where('title', 'like', '%' . $this->search . '%')->get();
        
        return view('livewire.search-component', [
            'products' => $this->products,
        ]);
    }
}
