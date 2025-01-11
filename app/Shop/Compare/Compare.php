<?php

namespace App\Shop\Compare;

use App\Models\Product;
use Illuminate\Support\Collection;
use Session;

class Compare
{
    public function count()
    {
        return $this->get()->count();
    }

    public function toggle($id)
	{
        $compare = $this->get();
        $compareProduct = $compare->where('id', $id)->first();

		if (empty($compareProduct)) {

			$product = Product::find($id);

			if (empty($product)) {
				return 'Error';
			}

			$compare->push($product);
            Session::put('compare', $compare);

			return 'Compared';
		}

        $compare = $compare->filter(function($item) use ($id) {
            return $item->id != $id;
        });
        Session::put('compare', $compare);
		
		return 'Removed';
	}

    public function removeCategory($id)
    {
        $compare = $this->get();

        $compare = $compare->filter(function($item) use ($id) {
            return $item->id_categories != $id;
        });

        Session::put('compare', $compare);
		
		return 'Removed';
    }

    public function setMain($id)
    {
        $compare = $this->get();
        
        $compare = $compare->map(function($item) use ($id) {
            
            if ($item->id == $id) {
                $item->is_main = 1;
            } else {
                $item->is_main = 0;
            }
            
            return $item;
        });

        Session::put('compare', $compare);
    }

    public function get()
    {    
        $compare = Session::has('compare')
            ? Session::get('compare')
            : new Collection();

        return $compare;
    }

    public function clear()
    {
        Session::remove('compare');
    }
}