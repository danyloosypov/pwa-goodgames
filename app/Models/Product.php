<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\Genre;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends MultilanguageModel
{
    use HasFactory;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'title',
		'slug',
		'price',
		'old_price',
		'sku',
		'excerpt',
		'release_date',
		'pegi_rating',
		'image',
		'gallery',
		'installer',
		'is_active',
		'meta_title',
		'meta_description',
		'meta_keywords',
	];

    #region Relationships

	public function genres() 
	{
		return $this->belongsToMany(Genre::class, 'products_genres', 'id_products', 'id_genres');
	}

	public function productCategories() 
	{
		return $this->belongsToMany(ProductCategory::class, 'products_product_categories', 'id_products', 'id_product_categories');
	}

	public function productTags() 
	{
		return $this->belongsToMany(ProductTag::class, 'products_product_tags', 'id_products', 'id_product_tags');
	}

	public function platforms() 
	{
		return $this->belongsToMany(Platform::class, 'products_platforms', 'id_products', 'id_platforms');
	}

	#endregion
}