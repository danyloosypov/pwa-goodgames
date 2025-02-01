<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDiscount extends Model
{
    use HasFactory;

    protected $table = 'cart_discounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'money',
		'value',
		'symbol',
    ];

    #region Relationships
    
    

    #endregion
}