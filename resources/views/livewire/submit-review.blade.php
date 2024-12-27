<div class="nk-reply">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($parentReview)
        <div class="alert alert-info">
            <strong>Replying to:</strong> {{ $parentReview->text }}
            <button type="button" wire:click="cancelReply" class="btn btn-sm btn-danger float-right">Cancel Reply</button>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="nk-form">
        <div class="nk-gap-1"></div>
        <textarea class="form-control required" wire:model="message" rows="5" placeholder="Your Review *"></textarea>
        @error('message') <span class="text-danger">{{ $message }}</span> @enderror
        <div class="nk-gap-1"></div>
        <div class="nk-rating">
            <input type="radio" id="review-rate-5" name="review-rate" wire:model="rating" value="5">
            <label for="review-rate-5">
                <span><i class="far fa-star"></i></span>
                <span><i class="fa fa-star"></i></span>
            </label>

            <input type="radio" id="review-rate-4" name="review-rate" wire:model="rating" value="4">
            <label for="review-rate-4">
                <span><i class="far fa-star"></i></span>
                <span><i class="fa fa-star"></i></span>
            </label>
            <input type="radio" id="review-rate-3" name="review-rate" wire:model="rating" value="3">
            <label for="review-rate-3">
                <span><i class="far fa-star"></i></span>
                <span><i class="fa fa-star"></i></span>
            </label>
            <input type="radio" id="review-rate-2" name="review-rate" wire:model="rating" value="2">
            <label for="review-rate-2">
                <span><i class="far fa-star"></i></span>
                <span><i class="fa fa-star"></i></span>
            </label>
            <input type="radio" id="review-rate-1" name="review-rate" wire:model="rating" value="1">
            <label for="review-rate-1">
                <span><i class="far fa-star"></i></span>
                <span><i class="fa fa-star"></i></span>
            </label>
            @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="nk-btn nk-btn-rounded nk-btn-color-dark-3 float-right">Submit</button>
    </form>
</div>
