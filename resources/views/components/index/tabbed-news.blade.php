<!-- START: Tabbed News  -->
<div class="nk-gap-3"></div>
<h3 class="nk-decorated-h-2"><span><span class="text-main-1">Tabbed</span> News</span></h3>
<div class="nk-gap"></div>
<div class="nk-tabs">
    <ul class="nav nav-tabs nav-tabs-fill" role="tablist">
        @foreach ($categories as $category)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="#tab-{{$category->id}}" role="tab" data-toggle="tab">{{$category->title}}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($categories as $category)
            <div role="tabpanel" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{$category->id}}">
                <div class="nk-gap"></div>
                
                @foreach ($category->articles as $post)
                    <!-- Display the first article with the current layout -->
                    @if ($loop->first)
                        <div class="nk-blog-post nk-blog-post-border-bottom">
                            <a href="{{ route('article', $post->slug) }}" class="nk-post-img">
                                <img src="{{ $post->image }}" alt="{{ $post->title }}" style="max-height: 250px; object-fit: cover">
                                <span class="nk-post-categories">
                                    <span class="bg-main-{{ $loop->parent->iteration }}">{{ $category->title }}</span>
                                </span>
                            </a>
                            <div class="nk-gap-1"></div>
                            <h2 class="nk-post-title h4"><a href="{{ route('article', $post->slug) }}">{{ $post->title }}</a></h2>
                            <div class="nk-post-date mt-10 mb-10">
                                <span class="fa fa-calendar"></span> {{ \Carbon\Carbon::parse($post->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                                <span class="fa fa-comments"></span> <a href="#">{{ $post->reviews_count }} comments</a>
                            </div>
                            <div class="nk-post-text">
                                <p>{{ Str::limit($post->excerpt, 150) }}</p>
                            </div>
                        </div>
                    @else
                        <!-- Display the rest of the articles with the new layout -->
                        <div class="nk-blog-post nk-blog-post-border-bottom">
                            <div class="row vertical-gap">
                                <div class="col-lg-3 col-md-5">
                                    <a href="{{ route('article', $post->slug) }}" class="nk-post-img">
                                        <img src="{{ $post->image }}" alt="{{ $post->title }}">
                                        <span class="nk-post-categories">
                                            <span class="bg-main-{{ $loop->parent->iteration }}">{{ $category->title }}</span>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-lg-9 col-md-7">
                                    <h2 class="nk-post-title h4"><a href="{{ route('article', $post->slug) }}">{{ $post->title }}</a></h2>
                                    <div class="nk-post-date mt-10 mb-10">
                                        <span class="fa fa-calendar"></span> {{ \Carbon\Carbon::parse($post->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                                        <span class="fa fa-comments"></span> <a href="#">{{ $post->reviews_count }} comments</a>
                                    </div>
                                    <div class="nk-post-text">
                                        <p>{{ Str::limit($post->excerpt, 150) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                
                <div class="nk-gap"></div>
            </div>
        @endforeach
    </div>    
</div>
