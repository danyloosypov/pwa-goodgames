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
                    <span>Faker</span>
                </li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->
        <div class="container">
            <div class="row vertical-gap">
                <div class="col-lg-8">
                    <!-- START: Teammate Card -->
                    <div class="nk-teammate-card">
                        <div class="nk-teammate-card-photo">
                            <img src="{{$teammate->photo}}" alt="Faker">
                        </div>
                        <div class="nk-teammate-card-info">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="{{$teammate->team->logo}}" alt="">
                                        </td>
                                        <td>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <strong class="h5">Name:</strong>&nbsp;&nbsp;&nbsp;
                                                        </td>
                                                        <td>
                                                            <strong class="h5">{{$teammate->real_name}}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <strong class="h5">Nickname:</strong>&nbsp;&nbsp;&nbsp;
                                                        </td>
                                                        <td>
                                                            <strong class="h5">{{$teammate->nickname}}</strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="h3">{{$teammate->kda_ration_num}}</strong>
                                        </td>
                                        <td>
                                            <strong class="h5">KDA Ration</strong>
                                            <div>{{$teammate->kda_ration_text}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="h3">{{$teammate->cs_per_min_num}}</strong>
                                        </td>
                                        <td>
                                            <strong class="h5">CS PER MIN</strong>
                                            <div>{{$teammate->cs_per_min_text}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="h3">{{$teammate->kill_participation_num}}%</strong>
                                        </td>
                                        <td>
                                            <strong class="h5">KILL PARTICIPATION</strong>
                                            <div>{{$teammate->kill_participation_text}}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END: Teammate Card -->
                    <!-- START: Biography -->
                    <div class="nk-gap-3"></div>
                    <h3 class="nk-decorated-h-2">
                        <span>Biography</span>
                    </h3>
                    {!! $teammate->biography !!}
                    <!-- END: Biography -->
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
                    <!-- END: Upcoming Matches -->
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