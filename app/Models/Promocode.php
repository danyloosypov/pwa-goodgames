<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Promocode extends Model
{
    use HasFactory;

    protected $table = 'promocodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'title',
		'value',
		'symbol',
		'is_once',
		'date_start',
		'date_end',
		'is_used',
	];

    #region Relationships

	public function productCategories() 
	{
		return $this->belongsToMany(ProductCategory::class, 'promocodes_product_categories', 'id_promocodes', 'id_product_categories');
	}

	public function genres() 
	{
		return $this->belongsToMany(Genre::class, 'promocodes_genres', 'id_promocodes', 'id_genres');
	}

	public function products() 
	{
		return $this->belongsToMany(Product::class, 'promocodes_products', 'id_promocodes', 'id_products');
	}

	#endregion

    public function getByTitle($title)
    {
        return $this->where('title', $title)->first();
    }

    public function getProductsIds()
    {
        return $this->products()->pluck('id_products')->toArray();
    }

    public function getGenresIds()
    {
        return $this->genres()->pluck('id_genres')->toArray();
    }

    public function getCategoriesIds()
    {
        return $this->productCategories()->pluck('id_product_categories')->toArray();
    }

    protected static function booted()
    {
        static::addGlobalScope('valid_promocodes', function (Builder $builder) {
            $currentTime = Carbon::now();
    
            $builder->where('is_used', 0)
                ->where('date_start', '<=', $currentTime)
                ->where(function ($query) use ($currentTime) {
                    $query->whereNull('date_end')
                          ->orWhere('date_end', '>=', $currentTime);
                });
        });
    }
}