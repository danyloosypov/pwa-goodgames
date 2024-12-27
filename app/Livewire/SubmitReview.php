<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class SubmitReview extends Component
{
    public $message;
    public $rating = 5; 
    public $productId = 0;
    public $articleId = 0;
    public $reviewsId = 0;
    public $parentReview;

    protected $rules = [
        'message' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
    ];

    protected $listeners = ['selectedReviewIdUpdated' => 'updateReviewId'];

    public function updateReviewId($reviewId)
    {
        $this->reviewsId = $reviewId;
        $this->parentReview = Review::find($reviewId);
    }

    public function cancelReply()
    {
        $this->reviewsId = 0;
        $this->parentReview = null;
    }

    public function submit()
    {
        $this->dispatch('loading-start')->to(Loading::class);

        if (!Auth::user()) {
            session()->flash('error', 'You need to be authorized!');
            $this->dispatch('loading-finished')->to(Loading::class);
            return;
        }

        $this->validate();

        Review::create([
            'id_users' => Auth::user()->id,  
            'rating' => $this->rating,
            'date' => now(),
            'text' => $this->message,
            'id_products' => $this->productId,
            'id_articles' => $this->articleId,
            'id_reviews' => $this->reviewsId,
        ]);

        $this->reset(['message', 'rating', 'reviewsId']);

        session()->flash('message', 'Review submitted successfully!');

        $this->cancelReply();

        $this->dispatch('loading-finished')->to(Loading::class);
    }

    public function render()
    {
        return view('livewire.submit-review', [
            'parentReview' => $this->parentReview
        ]);
    }
}
