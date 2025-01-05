<!-- START: Latest Matches -->
<div class="nk-gap-2"></div>
<h3 class="nk-decorated-h-2"><span><span class="text-main-1">Latest</span> Matches</span></h3>
<div class="nk-gap"></div>
@foreach ($matches as $match)
    <div class="nk-match">
        <div class="nk-match-team-left">
            <div>
                <span class="nk-match-team-logo">
                    <img src="{{$match->teams[0]->logo}}" alt="">
                </span>
                <span class="nk-match-team-name">
                    {{$match->teams[0]->title}}
                </span>
            </div>
        </div>
        <a href="{{ route('tournament', ['tournament' => $match->tournament->slug]) }}" class="nk-match-status">
            <div>
                <span class="nk-match-status-vs">VS</span>
                <span class="nk-match-status-date">{{$match->tournament->game_name}} - {{ \Carbon\Carbon::parse($match->datetime)->locale(app()->getLocale())->translatedFormat('M d, Y') }}</span>
                <span class="nk-match-score bg-danger">
                    {{$match->result}}
                </span>
            </div>
        </a>
        <div class="nk-match-team-right">
            <div>
                <span class="nk-match-team-name">
                    {{$match->teams[1]->title}}
                </span>
                <span class="nk-match-team-logo">
                    <img src="{{$match->teams[1]->logo}}" alt="">
                </span>
            </div>
        </div>
    </div>
@endforeach
<!-- END: Latest Matches -->