<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\Teammate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends MultilanguageModel
{
    use HasFactory;

    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'title',
		'slug',
		'logo',
		'description',
		'team_photo',
		'meta_title',
		'meta_description',
		'meta_keywords',
	];

    #region Relationships

	public function teammates() 
	{
		return $this->hasMany(Teammate::class, 'id_teams');
	}

	#endregion
}