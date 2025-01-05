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
                    <span>Tournaments</span>
                </li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->
        <div class="container">
            <div class="row vertical-gap">
                <div class="col-lg-8">
                    @foreach ($tournaments as $tournament)
                        <!-- START: Now Playing -->
                        <div class="nk-match accordion" style="justify-content: space-between; cursor: pointer">
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
                        <div class="accordion-body">
                            <div class="responsive-embed responsive-embed-16x9">
                                <iframe src="https://player.twitch.tv/?channel=eulcs" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe>
                            </div>
                            <!-- END: Now Playing -->
                            <!-- START: Match Description -->
                            <div class="nk-gap-2"></div>
                            {!! $tournament->description !!}
                            <!-- END: Match Description -->
                        </div>
                        
                        <div class="nk-gap-1"></div>
                    @endforeach
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
                    <x-index.latest-matches />
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

<style>
    .accordion-body {
        display: none;
    }

    .accordion:after {
        content: '\002B';
        color: white;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .accordion.active:after {
        content: '\2212';
        color: #dd163b;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }
</style>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;
    
    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
          panel.style.display = "none";
        } else {
          panel.style.display = "block";
        }
      });
    }
</script>