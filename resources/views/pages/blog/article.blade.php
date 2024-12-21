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
                    <a href="#">Blog</a>
                </li>
                <li>
                    <span class="fa fa-angle-right"></span>
                </li>
                <li>
                    <span>{{$article->title}}</span>
                </li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->
        <div class="container">
            <div class="row vertical-gap">
                <div class="col-lg-8">
                    <!-- START: Post -->
                    <div class="nk-blog-post nk-blog-post-single">
                        <!-- START: Post Text -->
                        <div class="nk-post-text mt-0">
                            <div class="nk-post-img">
                                <img src="{{$article->image}}" alt="{{$article->title}}">
                            </div>
                            <div class="nk-gap-1"></div>
                            <h1 class="nk-post-title h4">{{$article->title}}</h1>
                            <div class="nk-post-by">
                                {{$article->date}}
                                @if ($article->articleTag)
                                    <span class="nk-post-categories">
                                        <span class="bg-main-4" style="background: {{$article->articleTag->color}} !important">{{$article->articleTag->title}}</span>
                                    </span>
                                @endif
                            </div>
                            <div class="nk-gap"></div>
                            {!! $article->content !!}
                            <div class="nk-gap"></div>
                            <div class="nk-post-share">
                                <span class="h5">Share Article:</span>
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
                                    <!-- Additional Share Buttons
                            <li><span class="nk-social-linkedin" title="Share page on LinkedIn" data-share="linkedin"><span class="fab fa-linkedin"></span></span></li><li><span class="nk-social-vk" title="Share page on VK" data-share="vk"><span class="fab fa-vk"></span></span></li>
                        -->
                                </ul>
                            </div>
                        </div>
                        <!-- END: Post Text -->
                        <!-- START: Similar Articles -->
                        <div class="nk-gap-2"></div>
                        <h3 class="nk-decorated-h-2">
                            <span>
                                <span class="text-main-1">Similar</span> Articles </span>
                        </h3>
                        <div class="nk-gap"></div>
                        <div class="row">
                            @foreach ($similarArticles as $item)
                                <div class="col-md-6">
                                    <div class="nk-blog-post">
                                        <a href="{{ route('article', ['article' => $item->slug]) }}" class="nk-post-img">
                                            <img src="{{$item->image}}" alt="We found a witch! May we burn her?">
                                            <span class="nk-post-comments-count">{{$item->reviews_count}}</span>
                                            @if ($item->articleTag)
                                                <span class="nk-post-categories">
                                                    <span class="bg-main-4" style="background: {{$item->articleTag->color}} !important">{{$item->articleTag->title}}</span>
                                                </span>
                                            @endif
                                        </a>
                                        <div class="nk-gap"></div>
                                        <h2 class="nk-post-title h4">
                                            <a href="blog-article.html">{{$item->title}}</a>
                                        </h2>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- END: Similar Articles -->
                        <!-- START: Comments -->
                        <div id="comments"></div>
                        <h3 class="nk-decorated-h-2">
                            <span>
                                <span class="text-main-1">{{$article->reviews_count}}</span> Comments </span>
                        </h3>
                        <div class="nk-gap"></div>
                        <div class="nk-comments">
                            @foreach ($article->reviews as $review)
                                <!-- START: Comment -->
                                <div class="nk-comment">
                                    <div class="nk-comment-meta">
                                        <img src="{{$review->user->avatar}}" alt="Witch Murder" class="rounded-circle" width="35"> by <a href="#">{{$review->user->name}}</a> in {{ \Carbon\Carbon::parse($review->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }} <a href="#" class="nk-btn nk-btn-rounded nk-btn-color-dark-3 float-right">Reply</a>
                                    </div>
                                    <div class="nk-comment-text">
                                        <p>{{$review->text}}</p>
                                    </div>
                                    @if ($review->admin_reply)
                                        <div class="nk-comment">
                                            <div class="nk-comment-meta">
                                                <img src="/images/avatar-1.jpg" alt="Hitman" class="rounded-circle" width="35"> by <a href="#">Admin</a> in {{ \Carbon\Carbon::parse($review->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                                            </div>
                                            <div class="nk-comment-text">
                                                <p>{{$review->admin_reply}}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach ($review->children as $childrenReview)
                                        <!-- START: Comment -->
                                        <div class="nk-comment">
                                            <div class="nk-comment-meta">
                                                <img src="{{$childrenReview->user->admin}}" alt="Hitman" class="rounded-circle" width="35"> by <a href="#">{{$childrenReview->user->name}}</a> in {{ \Carbon\Carbon::parse($childrenReview->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }} 
                                            </div>
                                            <div class="nk-comment-text">
                                                <p>{{$childrenReview->text}}</p>
                                            </div>
                                        </div>
                                        <!-- END: Comment -->
                                    @endforeach
                                </div>
                                <!-- END: Comment -->
                            @endforeach
                        </div>
                        <!-- END: Comments -->
                        <!-- START: Reply -->
                        <div class="nk-gap-2"></div>
                        <h3 class="nk-decorated-h-2">
                            <span>
                                <span class="text-main-1">Leave</span> a Reply </span>
                        </h3>
                        <div class="nk-gap"></div>
                        <div class="nk-reply">
                            <form action="#" class="nk-form" novalidate="novalidate">
                                <div class="row sm-gap vertical-gap">
                                    <div class="col-md-4">
                                        <input type="email" class="form-control required" name="email" placeholder="Email *">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control required" name="name" placeholder="Name *">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name" placeholder="Website">
                                    </div>
                                </div>
                                <div class="nk-gap-1"></div>
                                <textarea class="form-control required" name="message" rows="5" placeholder="Message *" aria-required="true"></textarea>
                                <div class="nk-gap-1"></div>
                                <div class="nk-form-response-success"></div>
                                <div class="nk-form-response-error"></div>
                                <button class="nk-btn nk-btn-rounded nk-btn-color-main-1">Post Comment</button>
                            </form>
                        </div>
                        <!-- END: Reply -->
                    </div>
                    <!-- END: Post -->
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