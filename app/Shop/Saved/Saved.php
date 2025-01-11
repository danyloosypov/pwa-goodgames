<?php 

namespace App\Shop\Saved;

use Illuminate\Support\Collection;
use App\Models\Saved as SavedModel;
use App\Models\Product;
use Auth;

class Saved {

	private $model;
	private $user;
	protected $saved = null;

	public function __construct(SavedModel $model)
	{
		$this->model = $model;
		$this->user = Auth::user();
	}

	public function count()
	{
		if (empty($this->user)) {
			return 0;
		}

		return $this->model->where('id_users', $this->user->id)
		->whereHas('product')
		->count();
	}

	public function toggle($id)
	{
		if (empty($this->user)) {
			return 'Not user';
		}

		$saved = $this->model->where('id_products', $id)
		->where('id_users', $this->user->id)
		->first();

		if (empty($saved)) {

			$product = Product::select('id')
			->where('id', $id)
			->first();

			if (empty($product)) {
				return 'Error';
			}

			$new_saved = new $this->model([
				'id_products'	=> $product->id,
				'id_users'		=> $this->user->id,
			]);				
			$new_saved->save();

			return 'Saved';
		}

		$this->model->where('id_products', $id)
		->where('id_users', $this->user->id)
		->delete();
		
		return 'Removed';
	}

	public function get()
	{
		if ($this->saved != null) {
			return $this->saved;
		}

		if (empty($this->user)) {
			return new Collection();
		}

		$this->saved = $this->model->where('id_users', $this->user->id)
		->get();

		$products = Product::select('id')
		->whereIn('id', $this->saved->pluck('id_products'))
		->get()
		->pluck('id');

		foreach ($this->saved as $key => $saved) {

			$productsToDelete = [];

			if (!$products->contains($saved->id_products)) {

				$productsToDelete[] = $saved->id_products;
				$this->saved->forget($key);
			}

			$this->model->whereIn('id_products', $productsToDelete)
			->delete();
		}

		return $this->saved;
	}

	public function clear()
	{
		$this->model->where('id_users', $this->user->id)
		->delete();
	}
}