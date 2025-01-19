<x-layout>

    <x-slot name="metaTitle">
        
    </x-slot>

    <x-slot name="metaDescription">
        
    </x-slot>

    <div class="thank-you-page container">
        <div class="nk-gap-1"></div>
        <div class="nk-gap-1"></div>
        <h1>Thank You for Your Order!</h1>

        <p>Your order has been placed successfully. Here are the details of your order:</p>

        <!-- Order Information -->
        <div class="order-info">
            <h2>Order #{{ $order->id }}</h2>
            <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->date)->format('F j, Y') }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>

            <!-- Customer Information -->
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Comment:</strong> {{ $order->comment }}</p>
        </div>

        <!-- Order Products -->
        <h3 class="nk-decorated-h-2">
            <span>
                <span class="text-main-1">Your</span> Order
            </span>
        </h3>
        <div class="nk-gap"></div>
        <div class="" id="checkout-products">
            <div class="table-responsive">
                <!-- START: Products in Cart -->
                <table class="table nk-store-cart-products">
                    <tbody>
                        @foreach ($order->orderProducts as $product)
                            <tr>
                                <td class="nk-product-cart-thumb">
                                    <div class="nk-image-box-1 nk-post-image">
                                        <img src="{{$product->image}}" alt="However, I have reason" width="115">
                                    </div>
                                </td>
                                <td class="nk-product-cart-title">
                                    <h5 class="h6">Product:</h5>
                                    <div class="nk-gap-1"></div>
            
                                    <h2 class="nk-post-title h4">
                                        <div>{{$product->title}}</div>
                                    </h2>
                                </td>
                                <td class="nk-product-cart-price">
                                    <h5 class="h6">Price:</h5>
                                    <div class="nk-gap-1"></div>
            
                                    <strong>₴ {{$product->price}}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- END: Products in Cart -->
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        </div>

        <div class="thank-you-message">
            <p>We appreciate your business! You will receive a confirmation email shortly.</p>
        </div>
        <div class="nk-gap-1"></div>
        <div class="nk-gap-1"></div>
    </div>

</x-layout>
