<?php

namespace App\View\Components\Index;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\TournamentMatch;
use Carbon\Carbon;

class LatestMatches extends Component
{
    public $matches;

    public function __construct()
    {
        $this->matches = TournamentMatch::with(['teams', 'tournament'])
            ->whereBetween('datetime', [Carbon::now()->subWeek(), Carbon::now()]) // Date is between a week ago and now
            ->where(function ($query) {
                $query->whereNull('result')
                      ->orWhere('result', ''); 
            })
            ->orderBy('datetime', 'asc') 
            ->limit(5)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.index.latest-matches');
    }
}
