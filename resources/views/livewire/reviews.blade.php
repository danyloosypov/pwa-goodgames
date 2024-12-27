<div class="nk-comments">
    @foreach ($reviews as $review)
        <!-- START: Comment -->
        <div class="nk-comment">
            <div class="nk-comment-meta">
                <img src="{{$review->user->avatar}}" alt="Witch Murder" class="rounded-circle" width="35"> by <a href="#">{{$review->user->name}}</a> in {{ \Carbon\Carbon::parse($review->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }} <div class="nk-btn nk-btn-rounded nk-btn-color-dark-3 float-right" wire:click="setReviewId({{ $review->id }})">Reply</div>
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
    <div class="nk-gap-2"></div>
    {{ $reviews->links() }}
</div>