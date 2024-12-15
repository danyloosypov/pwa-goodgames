<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends MultilanguageModel
{
    use HasFactory;

    protected $table = 'tournament_matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'datetime',
		'result',
		'id_tournaments',
	];

    #region Relationships

	public function teams() 
	{
		return $this->belongsToMany(Team::class, 'tournament_matches_teams', 'id_tournament_matches', 'id_teams');
	}

	public function tournament() 
	{
		return $this->belongsTo(Tournament::class, 'id_tournaments');
	}

	#endregion
}