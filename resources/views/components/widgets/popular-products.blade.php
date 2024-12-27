<div class="nk-widget nk-widget-highlighted">
    <h4 class="nk-widget-title">
        <span>
            <span class="text-main-1">Most</span> Popular </span>
    </h4>
    <div class="nk-widget-content">
        @foreach ($products as $product)
            <div class="nk-widget-post">
                <a href="{{ route('product', ['product' => $product->slug]) }}" class="nk-post-image">
                    <img src="{{$product->image}}" alt="{{$product->title}}">
                </a>
                <h3 class="nk-post-title">
                    <a href="{{ route('product', ['product' => $product->slug]) }}">{{$product->title}}</a>
                </h3>
                <div class="nk-product-rating" data-rating="{{$product->reviews_avg_rating}}">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $product->reviews_avg_rating)
                            <i class="fa fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="nk-product-price">₴ {{$product->price}}</div>
            </div>
        @endforeach
    </div>
</div>