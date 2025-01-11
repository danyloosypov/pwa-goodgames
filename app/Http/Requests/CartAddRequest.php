<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CartAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
            'count'         => intval($this->count),
            'id_products'   => intval($this->id_products),
			'is_checkout'   => (bool)($this->is_checkout),
		]);
	}

    public function rules()
    {
        $productsIds = Product::select('id')
		->get()
		->pluck('id')
		->implode(',');

		$rules = [
			'id_products'   => ['required', 'numeric', 'in:'.$productsIds],
            'count'         => ['required', 'numeric'],
            'meta'          => ['string', 'nullable'],
            'is_checkout'   => ['boolean'],
        ];

        return $rules;
    }
}
