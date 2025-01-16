<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_users',
		'id_products',
		'qty',
		'meta',
    ];

    #region Relationships
    
    public function user() 
	{
		return $this->belongsTo(User::class, 'id_users');
	}

	public function product() 
	{
		return $this->belongsTo(Product::class, 'id_products');
	}

    #endregion
}