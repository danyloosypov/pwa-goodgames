<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'image',
		'title',
		'price',
		'id_products',
		'id_orders',
		'installer',
	];

    #region Relationships

	public function product() 
	{
		return $this->belongsTo(Product::class, 'id_products');
	}

	public function order() 
	{
		return $this->belongsTo(Order::class, 'id_orders');
	}

	#endregion
}