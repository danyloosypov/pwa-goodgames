<div>
    <!-- Start: Tabs -->
    <div class="nk-tabs">
        <ul class="nav nav-tabs nav-tabs-fill">
            <li class="nav-item">
                <div class="nav-link {{$categoryId == null ? 'active' : ''}}" wire:click="setCategory(0)">All</div>
            </li>
            @foreach ($categories as $category)
                <li class="nav-item">
                    <div class="nav-link {{$categoryId == $category->id ? 'active' : ''}}" wire:click="setCategory({{ $category->id }})">{{ $category->title }}</div>
                </li>
            @endforeach
        </ul>
        <div class="nk-gap"></div>
    </div>
    <!-- End: Tabs -->

    <!-- Start: Posts Grid -->
    <div class="nk-blog-grid">
        <div class="row">
            @foreach ($posts as $post)
            <div class="col-md-6">
                <div class="nk-blog-post">
                    <a href="{{ route('article', ['article' => $post->slug]) }}" class="nk-post-img">
                        <img src="{{$post->image}}" alt="{{$post->title}}">
                        @if ($post->articleTag)
                            <span class="nk-post-categories">
                                <span class="bg-main-4" style="background: {{$post->articleTag->color}} !important">{{$post->articleTag->title}}</span>
                            </span>
                        @endif
                    </a>
                    <div class="nk-gap"></div>
                    <h2 class="nk-post-title h4">
                        <a href="{{ route('article', ['article' => $post->slug]) }}">{{$post->title}}</a>
                    </h2>
                    <div class="nk-post-text">
                        <p>{{$post->excerpt}}</p>
                    </div>
                    <div class="nk-gap"></div>
                    <a href="{{ route('article', ['article' => $post->slug]) }}" class="nk-btn nk-btn-rounded nk-btn-color-dark-3 nk-btn-hover-color-main-1">Read More</a>
                    <div class="nk-post-date float-right">
                        <span class="fa fa-calendar"></span> {{ \Carbon\Carbon::parse($post->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- End: Posts Grid -->

    {{ $posts->links() }}
</div>
