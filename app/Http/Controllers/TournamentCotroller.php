<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tournament;
use App\Models\Teammate;
use App\Models\TournamentMatch;

class TournamentCotroller extends Controller
{
	public function index(Request $request)
	{
        $today = Carbon::today();

        $tournaments = Tournament::where('date', '>=', $today)
                                ->orderBy('date', 'asc')
                                ->get();

        return view('pages.tournaments.tournaments', compact('tournaments'));
	}

    public function show($slug)
    {
        $tournament = Tournament::where('slug', $slug)
            ->firstOrFail();

        return view('pages.tournaments.tournament', [
            'tournament' => $tournament,
        ]);
    }

    public function teammate($slug)
    {
        $teammate = Teammate::where('slug', $slug)->first();

        if(!$teammate)
        {
            abort('404');
        }

        $team = $teammate->team;

        // Get all tournament matches for the team
        $matches = TournamentMatch::whereHas('teams', function ($query) use ($team) {
            $query->where('id_teams', $team->id);
        })
        ->with('tournament')
        ->where('datetime', '>=', Carbon::now()) // Upcoming matches
        ->orderBy('datetime', 'asc') // Sort by date
        ->get();

        // Get the latest match
        $latestMatches = TournamentMatch::whereHas('teams', function ($query) use ($team) {
            $query->where('id_teams', $team->id);
        })
        ->with('tournament')
        ->orderBy('datetime', 'desc') // Sort by date descending
        ->get();

        return view('pages.teams.teammate', [
            'teammate' => $teammate,
            'upcoming_matches' => $matches,
            'latest_matches' => $latestMatches
        ]);
    }
}