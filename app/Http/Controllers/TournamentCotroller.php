<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;

class TournamentCotroller extends Controller
{
	public function index(Request $request)
	{
        return view('pages.tournaments.tournaments'); 
	}

    public function show($slug)
    {
        $tournament = Tournament::where('slug', $slug)
            ->firstOrFail();

        return view('pages.tournaments.tournament', [
            'tournament' => $tournament,
        ]);
    }
}