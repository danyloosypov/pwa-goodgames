<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\ArticleTag;
use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Article extends MultilanguageModel
{
    use HasFactory;

    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'title',
		'slug',
		'date',
		'excerpt',
		'image',
		'id_article_tags',
		'id_article_categories',
		'content',
		'is_show',
		'meta_title',
		'meta_description',
		'meta_keywords',
	];

    #region Relationships

	public function articleTag() 
	{
		return $this->belongsTo(ArticleTag::class, 'id_article_tags');
	}

	public function articleCategory() 
	{
		return $this->belongsTo(ArticleCategory::class, 'id_article_categories');
	}

	public function reviews() 
	{
		return $this->hasMany(Review::class, 'id_articles');
	}

	#endregion

	protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('date', 'DESC');
        });

        static::addGlobalScope('is_show', function (Builder $builder) {
            $builder->where('is_show', 1);
        });
    }

	public function scopeWithCategoryAndTag(Builder $query)
    {
        $query->with(['articleCategory', 'articleTag'])
            ->withCount('reviews');;
    }
}