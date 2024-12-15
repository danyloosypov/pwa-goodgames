<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teammate extends MultilanguageModel
{
    use HasFactory;

    protected $table = 'teammates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'nickname',
		'slug',
		'real_name',
		'photo',
		'kda_ration_num',
		'kda_ration_text',
		'cs_per_min_num',
		'cs_per_min_text',
		'kill_participation_num',
		'kill_participation_text',
		'biography',
		'id_teams',
		'meta_title',
		'meta_description',
		'meta_keywords',
	];

    #region Relationships

	public function team() 
	{
		return $this->belongsTo(Team::class, 'id_teams');
	}

	#endregion
}