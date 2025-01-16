<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'name',
		'email',
		'subtotal',
		'total',
		'is_paid',
		'date',
		'id_order_statuses',
		'id_users',
	];

    #region Relationships

	public function orderStatus() 
	{
		return $this->belongsTo(OrderStatus::class, 'id_order_statuses');
	}

	public function orderProducts() 
	{
		return $this->hasMany(OrderProduct::class, 'id_orders');
	}

	public function user() 
	{
		return $this->belongsTo(User::class, 'id_users');
	}

	#endregion
}