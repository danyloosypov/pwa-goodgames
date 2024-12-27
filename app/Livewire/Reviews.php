<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination;

    public $productId;
    public $articleId;
    public $reviewId = 0;

    protected $updatesQueryString = ['page'];

    public function setReviewId($reviewId)
    {
        $this->reviewsId = $reviewId;
        $this->dispatch('selectedReviewIdUpdated', $reviewId);
    }

    public function render()
    {
        if ($this->productId) {
            $reviews = Review::where('id_products', $this->productId)->paginate(10);
        } else {
            $reviews = Review::where('id_articles', $this->articleId)->paginate(10);
        }

        return view('livewire.reviews', ['reviews' => $reviews]);
    }

    public function paginationView()
    {
        return 'custom-pagination-links-view';
    }
}
