<!-- START: Latest Posts -->
<h3 class="nk-decorated-h-2"><span><span class="text-main-1">Latest</span> Posts</span></h3>
<div class="nk-gap"></div>
<div class="nk-blog-grid">
    <div class="row">
        @foreach ($articles as $article)
            <div class="col-md-6">
                <!-- START: Post -->
                <div class="nk-blog-post">
                    <a href="{{ route('article', $article->slug) }}" class="nk-post-img">
                        <img src="{{ $article->image }}" alt="{{ $article->title }}">
                        <span class="nk-post-comments-count">{{ $article->reviews_count }}</span>
                    </a>
                    <div class="nk-gap"></div>
                    <h2 class="nk-post-title h4"><a href="{{ route('article', $article->slug) }}">{{ $article->title }}</a></h2>
                    <div class="nk-post-by">
                        in {{ \Carbon\Carbon::parse($article->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                    </div>
                    <div class="nk-gap"></div>
                    <div class="nk-post-text">
                        <p>{{ Str::limit($article->excerpt, 150) }}</p>
                    </div>
                    <div class="nk-gap"></div>
                    <a href="{{ route('article', $article->slug) }}" class="nk-btn nk-btn-rounded nk-btn-color-dark-3 nk-btn-hover-color-main-1">Read More</a>
                </div>
                <!-- END: Post -->
            </div>
        @endforeach
    </div>
</div>
<!-- END: Latest Posts -->
