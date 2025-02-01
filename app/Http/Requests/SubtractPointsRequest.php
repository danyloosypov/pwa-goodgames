<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubtractPointsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'subtract_points' => ['boolean'],
        ];
    }
}
