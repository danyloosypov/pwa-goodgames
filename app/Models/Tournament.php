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
		'date',
		'game_name',
		'meta_title',
		'meta_description',
		'meta_keywords',
	];

    #region Relationships

	public function tournamentMatches() 
	{
		return $this->hasMany(TournamentMatch::class, 'id_tournaments');
	}

	#endregion
}