<!-- START: Latest News -->
<div class="nk-gap-2"></div>
<h3 class="nk-decorated-h-2"><span><span class="text-main-1">Latest</span> News</span></h3>
<div class="nk-gap"></div>

<div class="nk-news-box">
	<div class="nk-news-box-list">
		<div class="nano">
			<div class="nano-content">
				@foreach ($articles as $article)
                    <div class="nk-news-box-item nk-news-box-item-active">
                        <div class="nk-news-box-item-img">
                            <img src="{{$article->image}}" alt="{{$article->title}}">
                        </div>
                        <img src="{{$article->image}}" alt="{{$article->title}}" class="nk-news-box-item-full-img">
                        <h3 class="nk-news-box-item-title">{{$article->title}}</h3>
                        
                        @if ($article->articleTag)
                            <span class="nk-post-categories">
                                <span class="bg-main-4" style="background: {{$article->articleTag->color}} !important">{{$article->articleTag->title}}</span>
                            </span>
                        @endif
                        
                        <div class="nk-news-box-item-text">
                            {{$article->excerpt}}
                        </div>
                        <a href="{{ route('article', ['article' => $article->slug]) }}" class="nk-news-box-item-url">Read More</a>
                        <div class="nk-news-box-item-date"><span class="fa fa-calendar"></span> {{ \Carbon\Carbon::parse($article->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}</div>
                    </div>
                @endforeach				
			</div>
		</div>
	</div>
	<div class="nk-news-box-each-info">
		<div class="nano">
			<div class="nano-content">
				<div class="nk-news-box-item-image">
                    <img src="{{$articles[0]->image}}" alt="{{$articles[0]->title}}">
                    <span class="nk-news-box-item-categories">
                        @if($articles[0]->articleTag)
                            <span class="bg-main-4" style="background: {{$articles[0]->articleTag->color}} !important">{{$articles[0]->articleTag->title}}</span>
                        @endif
                    </span>
                </div>
                <h3 class="nk-news-box-item-title">{{$articles[0]->title}}</h3>
                <div class="nk-news-box-item-text">
                    <p>{{$articles[0]->excerpt}}</p>
                </div>
                <a href="{{ route('article', ['article' => $articles[0]->slug]) }}" class="nk-news-box-item-more">Read More</a>
                <div class="nk-news-box-item-date">
                    <span class="fa fa-calendar"></span> {{ \Carbon\Carbon::parse($articles[0]->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                </div>
			</div>
		</div>
	</div>
</div>

<div class="nk-gap-2"></div>
<div class="nk-blog-grid">
	<div class="row">
		@foreach ($articlesRow as $articleRow)
            <div class="col-md-6 col-lg-3">
                <!-- START: Post -->
                <div class="nk-blog-post">
                    <a href="{{ route('article', $articleRow->slug) }}" class="nk-post-img">
                        <img src="{{ $articleRow->image }}" alt="{{ $articleRow->title }}">
                        @if ($articleRow->articleTag)
                            <span class="nk-post-categories">
                                <span class="bg-main-4" style="background: {{$articleRow->articleTag->color}} !important">{{$articleRow->articleTag->title}}</span>
                            </span>
                        @endif
                        <span class="nk-post-comments-count">{{ $articleRow->reviews_count }}</span>
                    </a>
                    <div class="nk-gap"></div>
                    <h2 class="nk-post-title h4"><a href="{{ route('article', $articleRow->slug) }}">{{ $articleRow->title }}</a></h2>
                    <div class="nk-post-by">
                        in {{ \Carbon\Carbon::parse($articleRow->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                    </div>
                    <div class="nk-gap"></div>
                    <div class="nk-post-text">
                        <p>{{ Str::limit($articleRow->excerpt, 150) }}</p>
                    </div>
                    <div class="nk-gap"></div>
                    <a href="{{ route('article', $articleRow->slug) }}" class="nk-btn nk-btn-rounded nk-btn-color-dark-3 nk-btn-hover-color-main-1">Read More</a>
                </div>
                <!-- END: Post -->
            </div>
        @endforeach		
	</div>
</div>
<!-- END: Latest News -->