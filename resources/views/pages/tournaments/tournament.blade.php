<x-layout>

    <div class="nk-main">
        <!-- START: Breadcrumbs -->
        <div class="nk-gap-1"></div>
        <div class="container">
            <ul class="nk-breadcrumbs">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <span class="fa fa-angle-right"></span>
                </li>
                <li>
                    <span>Tournament</span>
                </li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->
        <div class="container">
            <div class="row vertical-gap">
                <div class="col-lg-8">
                    <!-- START: Now Playing -->
                    <div class="nk-match">
                        <div class="nk-match-team-left">
                            <a href="{{ route('tournament', ['tournament' => $tournament->slug]) }}">
                                <span class="nk-match-team-name">{{$tournament->title}}</span>
                            </a>
                        </div>
                        <div class="nk-match-status">
                            <a href="{{ route('tournament', ['tournament' => $tournament->slug]) }}">
                                <span class="nk-match-status-vs">{{ \Carbon\Carbon::parse($tournament->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}</span>
                                <span class="nk-match-score bg-dark-1">{{$tournament->game_name}}</span>
                            </a>
                        </div>
                    </div>
                    <div class="responsive-embed responsive-embed-16x9">
                        <iframe src="https://player.twitch.tv/?channel=eulcs" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe>
                    </div>
                    <!-- END: Now Playing -->
                    <!-- START: Match Description -->
                    <div class="nk-gap-2"></div>
                    {!! $tournament->description !!}
                    <!-- END: Match Description -->
                    <div class="nk-gap"></div>
                    <div class="">
                        <!-- START: Teams -->
                        @foreach ($teams as $team)
                            <div class="nk-team">
                                <div class="nk-team-logo">
                                    <img src="{{$team->logo}}" alt="">
                                </div>
                                <div class="nk-team-cont">
                                    <h3 class="h5 mb-20">
                                        <span class="text-main-1">Team:</span> {{$team->title}}
                                    </h3>
                                    <h4 class="h6 mb-5">Members:</h4>
                                    @foreach ($team->teammates as $key => $teammate)
                                        <a href="{{ route('teammate', ['teammate' => $teammate->slug]) }}">
                                            {{$teammate->nickname}}
                                        </a>
                                        @if (!$loop->last)
                                            , 
                                        @endif
                                    @endforeach
                                    <div class="nk-team-photo" style="background-image: url('{{$team->team_photo}}');"></div>
                                </div>
                            </div>
                        @endforeach
                        <!-- END: Teams -->
                    </div>
                    <!-- START: Share -->
                    <div class="nk-gap"></div>
                    <div class="nk-post-share">
                        <span class="h5">Share Tournament:</span>
                        <ul class="nk-social-links-2">
                            <li>
                                <span class="nk-social-facebook" title="Share page on Facebook" data-share="facebook">
                                    <span class="fab fa-facebook"></span>
                                </span>
                            </li>
                            <li>
                                <span class="nk-social-google-plus" title="Share page on Google+" data-share="google-plus">
                                    <span class="fab fa-google-plus"></span>
                                </span>
                            </li>
                            <li>
                                <span class="nk-social-twitter" title="Share page on Twitter" data-share="twitter">
                                    <span class="fab fa-twitter"></span>
                                </span>
                            </li>
                            <li>
                                <span class="nk-social-pinterest" title="Share page on Pinterest" data-share="pinterest">
                                    <span class="fab fa-pinterest-p"></span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <!-- END: Share -->
                    <!-- START: Latest Matches -->
                    <div class="nk-gap-2"></div>
                    <h3 class="nk-decorated-h-2">
                        <span>
                            <span class="text-main-1">Latest</span> Matches </span>
                    </h3>
                    <div class="nk-gap"></div>
                    @foreach ($latest_matches as $latest_match)
                        <div class="nk-match">
                            <div class="nk-match-team-left">
                                <a href="{{ route('tournament', ['tournament' => $latest_match->tournament->slug]) }}">
                                    <span class="nk-match-team-logo">
                                        <img src="{{$latest_match->teams[0]->logo}}" alt="">
                                    </span>
                                    <span class="nk-match-team-name"> {{$latest_match->teams[0]->title}} </span>
                                </a>
                            </div>
                            <div class="nk-match-status">
                                <a href="{{ route('tournament', ['tournament' => $latest_match->tournament->slug]) }}">
                                    <span class="nk-match-status-vs">VS</span>
                                    <span class="nk-match-status-date">{{$latest_match->tournament->game_name}} - {{ \Carbon\Carbon::parse($latest_match->datetime)->locale(app()->getLocale())->translatedFormat('M d, Y') }}</span>
                                    <span class="nk-match-score bg-danger"> {{$latest_match->result}} </span>
                                </a>
                            </div>
                            <div class="nk-match-team-right">
                                <a href="{{ route('tournament', ['tournament' => $latest_match->tournament->slug]) }}">
                                    <span class="nk-match-team-name"> {{$latest_match->teams[1]->title}} </span>
                                    <span class="nk-match-team-logo">
                                        <img src="{{$latest_match->teams[1]->logo}}" alt="">
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    <!-- END: Latest Matches -->
                    <!-- START: Upcoming Matches -->
                    <div class="nk-gap-3"></div>
                    <h3 class="nk-decorated-h-2">
                        <span>
                            <span class="text-main-1">Upcoming</span> Matches </span>
                    </h3>
                    <div class="nk-gap"></div>
                    @foreach ($upcoming_matches as $upcoming_match)
                        <div class="nk-match">
                            <div class="nk-match-team-left">
                                <a href="{{ route('tournament', ['tournament' => $upcoming_match->tournament->slug]) }}">
                                    <span class="nk-match-team-logo">
                                        <img src="{{$upcoming_match->teams[0]->logo}}" alt="">
                                    </span>
                                    <span class="nk-match-team-name"> {{$upcoming_match->teams[0]->title}} </span>
                                </a>
                            </div>
                            <div class="nk-match-status">
                                <a href="{{ route('tournament', ['tournament' => $upcoming_match->tournament->slug]) }}">
                                    <span class="nk-match-status-vs">VS</span>
                                    <span class="nk-match-status-date">{{$upcoming_match->tournament->game_name}} - {{ \Carbon\Carbon::parse($upcoming_match->datetime)->locale(app()->getLocale())->translatedFormat('M d, Y') }}</span>
                                    <span class="nk-match-score"> Upcoming </span>
                                </a>
                            </div>
                            <div class="nk-match-team-right">
                                <a href="{{ route('tournament', ['tournament' => $upcoming_match->tournament->slug]) }}">
                                    <span class="nk-match-team-name"> {{$upcoming_match->teams[1]->title}} </span>
                                    <span class="nk-match-team-logo">
                                        <img src="{{$upcoming_match->teams[1]->logo}}" alt="">
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    <!-- END: Latest Matches -->
                </div>
                <div class="col-lg-4">
                    <x-widgets.sidebar />
                </div>
            </div>
        </div>
        <div class="nk-gap-2"></div>

    <x-slot name="metaTitle">
		{{-- {{ $metaTitle }} --}}
	</x-slot>
	
	<x-slot name="metaDescription">
		{{-- {{ $metaDescription }} --}}
	</x-slot>

</x-layout>