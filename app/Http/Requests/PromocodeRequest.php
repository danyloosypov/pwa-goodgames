<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromocodeRequest extends FormRequest
{

    public function rules()
    {
		$rules = [
            'promocode'     => ['string', 'required'],
        ];

        return $rules;
    }
}
