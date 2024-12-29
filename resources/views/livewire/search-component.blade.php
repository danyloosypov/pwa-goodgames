<!-- START: Search Modal -->
<div class="nk-modal modal fade" id="modalSearch" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="ion-android-close"></span>
                </button>
                <h4 class="mb-0">Search</h4>
                <div class="nk-gap-1"></div>
                <div>
                    <input type="text" wire:model.lazy="search" class="form-control" placeholder="Type something and press Enter">
                
                    @if(strlen($search) > 2)
                        <ul class="list-group mt-2">
                            @if($products->isEmpty())
                                <li class="list-group-item">No products found</li>
                            @else
                                @foreach($products as $product)
                                    <li class="">
                                        <div class="nk-widget-post">
                                            <a href="{{ route('product', ['product' => $product->slug]) }}" class="nk-post-image">
                                                <img src="{{ $product->image }}" alt="{{ $product->title }}">
                                            </a>
                                            <h3 class="nk-post-title">
                                                <a href="{{ route('product', ['product' => $product->slug]) }}">{{ $product->title }}</a>
                                            </h3>
                                            <div class="nk-product-rating" data-rating="{{ $product->reviews_avg_rating }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $product->reviews_avg_rating)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="nk-product-price">₴ {{ $product->price }}</div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- END: Search Modal -->