<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\Platform;
use App\Models\ProductCategory;
use App\Models\Genre;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogDiscount extends Model
{
    use HasFactory;

    protected $table = 'catalog_discounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
		'value',
		'symbol',
		'is_active',
		'date_start',
		'date_end',
    ];

    #region Relationships
    
    public function platforms() 
	{
		return $this->belongsToMany(Platform::class, 'catalog_discounts_platforms', 'id_catalog_discounts', 'id_platforms');
	}

	public function productCategories() 
	{
		return $this->belongsToMany(ProductCategory::class, 'catalog_discounts_product_categories', 'id_catalog_discounts', 'id_product_categories');
	}

	public function genres() 
	{
		return $this->belongsToMany(Genre::class, 'catalog_discounts_genres', 'id_catalog_discounts', 'id_genres');
	}

	public function products() 
	{
		return $this->belongsToMany(Product::class, 'catalog_discounts_products', 'id_catalog_discounts', 'id_products');
	}

    #endregion
}