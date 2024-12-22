<div class="nk-widget nk-widget-highlighted">
    <h4 class="nk-widget-title">
        <span>
            <span class="text-main-1">Top 3</span> Recent </span>
    </h4>
    <div class="nk-widget-content">
        @foreach ($articles as $article)
            <div class="nk-widget-post">
                <a href="{{ route('article', ['article' => $article->slug]) }}" class="nk-post-image">
                    <img src="{{$article->image}}" alt="">
                </a>
                <h3 class="nk-post-title">
                    <a href="{{ route('article', ['article' => $article->slug]) }}">{{$article->title}}</a>
                </h3>
                <div class="nk-post-date">
                    <span class="fa fa-calendar"></span>    {{ \Carbon\Carbon::parse($article->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                </div>
            </div>
        @endforeach
    </div>
</div>