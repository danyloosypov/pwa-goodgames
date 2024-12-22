<div class="nk-widget nk-widget-highlighted">
    <h4 class="nk-widget-title">
        <span>
            <span class="text-main-1">Next</span> Matches </span>
    </h4>
    <div class="nk-widget-content">
        @foreach ($matches as $match)
            <div class="nk-widget-match">
                <a href="{{ route('tournament', ['tournament' => $match->tournament->slug]) }}">
                    <span class="nk-widget-match-left">
                        <span class="nk-widget-match-teams">
                            <span class="nk-widget-match-team-logo">
                                <img src="{{$match->teams[0]->logo}}" alt="">
                            </span>
                            <span class="nk-widget-match-vs">VS</span>
                            <span class="nk-widget-match-team-logo">
                                <img src="{{$match->teams[1]->logo}}" alt="">
                            </span>
                        </span>
                        <span class="nk-widget-match-date">{{$match->tournament->game_name}} - {{ \Carbon\Carbon::parse($match->datetime)->locale(app()->getLocale())->translatedFormat('M d, Y') }}</span>
                    </span>
                    <span class="nk-widget-match-right">
                        @if ($match->result)
                            <span class="nk-match-score bg-dark-1"> {{$match->result}} </span>
                        @else
                            <span class="nk-match-score"> Upcoming </span>
                        @endif
                    </span>
                </a>
            </div>
        @endforeach
    </div>
</div>