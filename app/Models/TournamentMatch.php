<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends MultilanguageModel
{
    use HasFactory;

    protected $table = 'matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'datetime',
		'result',
	];

    #region Relationships

	public function teams() 
	{
		return $this->belongsToMany(Team::class, 'tournament_matches_teams', 'id_tournament_matches', 'id_teams');
	}

	#endregion
}