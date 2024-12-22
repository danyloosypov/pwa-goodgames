<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends MultilanguageModel
{
    use HasFactory;

    protected $table = 'platforms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'title',
		'icon',
	];

    #region Relationships

	

	#endregion
}