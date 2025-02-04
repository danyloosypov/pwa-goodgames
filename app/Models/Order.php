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
		'id_payments',
		'comment',
		'stripe_session_id',
		'liqpay_id',
		'paypal_id',
		'coingate_id',
		'nowpayments_id',
		'id_promocodes',
		'points_used',
		'promocode_price',
		'discount_price',
	];

	protected $attributes = [
		'stripe_session_id' => '',
		'is_paid' => 0,
		'comment' => '',
		'liqpay_id' => '',
		'paypal_id' => '',
		'coingate_id' => '',
		'nowpayments_id' => '',
		'id_promocodes' => 0,
		'points_used' => 0,
		'promocode_price' => 0,
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

	public function payment() 
	{
		return $this->belongsTo(Payment::class, 'id_payments');
	}

	public function promocode() 
	{
		return $this->belongsTo(Promocode::class, 'id_promocodes');
	}

	#endregion
}