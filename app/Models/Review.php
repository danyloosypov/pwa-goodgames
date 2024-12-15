<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\User;
use App\Models\Product;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    #endregion
}