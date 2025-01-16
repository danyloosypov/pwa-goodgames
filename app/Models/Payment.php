<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends MultilanguageModel
{
    use HasFactory;

    const LIQPAY = 1;
    const WAYFORPAY = 2;
    const FONDY = 3;
    const STRIPE = 4;
    const PAYPAL = 5;

    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
		'description',
    ];

    #region Relationships
    
    

    #endregion
}