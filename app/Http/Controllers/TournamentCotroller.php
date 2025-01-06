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
            ->with(['tournamentMatches.teams'])
            ->firstOrFail();

        $teams = $tournament->tournamentMatches->flatMap(function ($match) {
            return $match->teams;
        })->unique('id'); // Make sure teams are unique based on their id

        $latestMatches = $tournament->tournamentMatches
            ->whereNotNull('result')
            ->where('datetime', '<', now())
            ->sortByDesc('datetime'); // Ensure latest matches are ordered from most recent to least recent
        
        // Select upcoming matches (where datetime is in the future)
        $upcomingMatches = $tournament->tournamentMatches
            ->where('datetime', '>', now())
            ->sortBy('datetime');
    
        return view('pages.tournaments.tournament', [
            'tournament' => $tournament,
            'teams' => $teams, // Pass teams as a separate collection
            'latest_matches' => $latestMatches, // Pass latest matches
            'upcoming_matches' => $upcomingMatches,
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