<?php

namespace App\Http\Requests;

use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Cart;
use Single;

class CheckoutSendRequest extends FormRequest
{

	protected function prepareForValidation()
	{
		$this->merge([
            'id_payments'                       => intval($this->id_payments),
            'comment'                           => strval($this->comment),
		]);
	}

    public function attributes()
	{
        $attributes = [
            'name'                  => 'Имя',
            'email'                 => 'Email',
			'comment'		        => 'Комментарий',
            'id_payments'           => 'Payment',
        ];


        return $attributes;
	}

    public function rules()
    {
        $paymentsIds = Payment::pluck('id')->implode(',');
        
        $rules = [
            'name'                  => ['required', 'string'],
            'email'                 => ['required', 'email'],
            'comment'               => ['nullable', 'string'],
            'id_payments'           => ['required', 'numeric', 'in:'.$paymentsIds],
        ];
    
        return $rules;
    }
}
