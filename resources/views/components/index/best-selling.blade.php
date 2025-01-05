<!-- START: Best Selling -->
<div class="nk-gap-3"></div>
<h3 class="nk-decorated-h-2"><span><span class="text-main-1">Best</span> Selling</span></h3>
<div class="nk-gap"></div>
<div class="row vertical-gap">
    @foreach ($bestSellingProducts as $product)
        <div class="col-md-6">
            <div class="nk-product-cat">
                <a class="nk-product-image" href="{{ route('product', ['product' => $product->slug]) }}">
                    <img src="{{$product->image}}" alt="{{$product->title}}">
                </a>
                <div class="nk-product-cont">
                    <h3 class="nk-product-title h5"><a href="{{ route('product', ['product' => $product->slug]) }}">{{$product->title}}</a></h3>
                    <div class="nk-gap-1"></div>
                    <div class="nk-product-rating" data-rating="{{$product->reviews_avg_rating}}">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $product->reviews_avg_rating)
                                <i class="fa fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="nk-gap-1"></div>
                    <div class="nk-product-price">₴ {{$product->price}}</div>
                    <div class="nk-gap-1"></div>
                    <a href="#" class="nk-btn nk-btn-rounded nk-btn-color-dark-3 nk-btn-hover-color-main-1">Add to Cart</a>
                </div>
            </div>
        </div>
    @endforeach    
</div>
<!-- END: Best Selling -->