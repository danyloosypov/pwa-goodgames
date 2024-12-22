<?php

namespace App\View\Components\Widgets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\TournamentMatch;
use Carbon\Carbon;

class NextMatches extends Component
{
    public $matches;

    public function __construct()
    {
        $this->matches = TournamentMatch::with(['teams', 'tournament'])
        ->where(function ($query) {
            $query->whereNull('result')
                  ->orWhere('result', ''); 
        })
        ->orWhere('datetime', '>', Carbon::now()) 
        ->orderBy('datetime', 'asc') 
        ->limit(3)
        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.next-matches');
    }
}
