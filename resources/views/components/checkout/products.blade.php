<div class="table-responsive">
    <!-- START: Products in Cart -->
    <table class="table nk-store-cart-products">
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="nk-product-cart-thumb">
                        <a href="{{ route('product', ['product' => $product->slug]) }}" class="nk-image-box-1 nk-post-image">
                            <img src="{{$product->image}}" alt="However, I have reason" width="115">
                        </a>
                    </td>
                    <td class="nk-product-cart-title">
                        <h5 class="h6">Product:</h5>
                        <div class="nk-gap-1"></div>

                        <h2 class="nk-post-title h4">
                            <a href="{{ route('product', ['product' => $product->slug]) }}">{{$product->title}}</a>
                        </h2>
                    </td>
                    <td class="nk-product-cart-price">
                        <h5 class="h6">Price:</h5>
                        <div class="nk-gap-1"></div>

                        <strong>₴ {{$product->price}}</strong>
                    </td>
                    <td class="nk-product-cart-remove" onclick="Cart.add({{$product->id}}, -1)"><span class="ion-android-close"></span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- END: Products in Cart -->
</div>