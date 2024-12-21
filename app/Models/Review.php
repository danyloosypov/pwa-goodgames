<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\User;
use App\Models\Product;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'id_users',
		'rating',
		'date',
		'text',
		'id_products',
		'id_articles',
		'id_reviews',
		'admin_reply',
	];

	protected $attributes = [
		'rating' => 5,
		'id_products' => 0,
		'id_articles' => 0,
		'id_reviews' => 0,
		'admin_reply' => '',
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

	public function article() 
	{
		return $this->belongsTo(Article::class, 'id_articles');
	}

	public function review() 
	{
		return $this->belongsTo(Review::class, 'id_reviews');
	}

	#endregion

	public function children()
	{
		return $this->hasMany(Review::class, 'id_reviews');
	}

	protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('date', 'DESC');
        });
    }
}