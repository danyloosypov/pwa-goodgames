<div>
    @if (Cart::count() > 0)
        @foreach ($products as $product)
            <div class="nk-widget-post">
                <a href="{{ route('product', ['product' => $product->slug]) }}" class="nk-post-image">
                    <img src="{{$product->image}}" alt="In all revolutions of">
                </a>
                <h3 class="nk-post-title">
                    <div class="nk-cart-remove-item" onclick="Cart.add({{$product->id}}, -1)">
                        <span class="ion-android-close"></span>
                    </div>
                    <a href="{{ route('product', ['product' => $product->slug]) }}">{{$product->title}}</a>
                </h3>
                <div class="nk-gap-1"></div>
                <div class="nk-product-price">₴ {{$product->price}}</div>
            </div>
        @endforeach
    @else
        Your cart is empty
    @endif
</div>