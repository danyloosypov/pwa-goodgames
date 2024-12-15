<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends MultilanguageModel
{
    use HasFactory;

    protected $table = 'tournaments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
		'slug',
		'description',
		'meta_title',
		'meta_description',
		'meta_keywords',
    ];

    #region Relationships
    
    

    #endregion
}