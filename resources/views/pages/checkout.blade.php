<x-layout>
    <div x-data="checkoutPage({{ json_encode($payments) }}, {{ json_encode($user) }})" class="nk-main">
        <!-- START: Breadcrumbs -->
        <div class="nk-gap-1"></div>
        <div class="container">
            <ul class="nk-breadcrumbs">
                <li>
                    <a href="{{route('home')}}">Home</a>
                </li>
                <li>
                    <span class="fa fa-angle-right"></span>
                </li>
                <li>
                    <a href="{{route('catalog')}}">Store</a>
                </li>
                <li>
                    <span class="fa fa-angle-right"></span>
                </li>
                <li>
                    <span>Checkout</span>
                </li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->

        <div class="container">
            <div class="nk-store nk-store-checkout">
                <h3 class="nk-decorated-h-2">
                    <span>
                        <span class="text-main-1">Billing</span> Details
                    </span>
                </h3>
                <div class="nk-gap"></div>
                <form action="#" class="nk-form">
                    <div class="row vertical-gap">
                        <div class="col-lg-12">
                            <div class="row vertical-gap">
                                <div class="col-sm-6">
                                    <label for="fname">Your Name <span class="text-main-1">*</span>:</label>
                                    <input type="text" class="form-control required" name="fname" id="fname" x-model="user.name">
                                </div>
                                <div class="col-sm-6">
                                    <label for="email">Email Address <span class="text-main-1">*</span>:</label>
                                    <input type="email" class="form-control required" name="email" id="email" x-model="user.email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-gap-2"></div>
                    <label for="notes">Order Notes:</label>
                    <textarea class="form-control" name="notes" id="notes" placeholder="Order Notes" rows="6" x-model="orderNotes"></textarea>
                </form>

                <!-- START: Order Products -->
                <div class="nk-gap-3"></div>
                <h3 class="nk-decorated-h-2">
                    <span>
                        <span class="text-main-1">Your</span> Order
                    </span>
                </h3>
                <div class="nk-gap"></div>
                <div class="" id="checkout-products">
                    <x-checkout.products />
                </div>
                <div id="checkout-info">
                    <x-checkout.info />
                </div>
                <!-- END: Order Products -->

                <!-- Payment Selection -->
                <div class="nk-gap-2"></div>
                <h3 class="nk-decorated-h-2">
                    <span><span class="text-main-1">Payment</span> Method</span>
                </h3>
                <div class="nk-gap"></div>
                <div class="payment-methods">
                    <template x-for="payment in payments" :key="payment.id">
                        <div>
                            <input type="radio" :id="'payment-' + payment.id" name="payment" :value="payment.id" x-model="selectedPaymentId" @change="changePaymentMethod(payment.id)">
                            <label :for="'payment-' + payment.id" x-text="payment.title"></label>
                        </div>
                    </template>
                </div>

                <div class="nk-gap-2"></div>
                <a class="nk-btn nk-btn-rounded nk-btn-color-main-1" href="#" @click.prevent="placeOrder()">Place Order</a>
            </div>
        </div>

        <div class="nk-gap-2"></div>

        <x-slot name="metaTitle">
            {{-- {{ $metaTitle }} --}}
        </x-slot>

        <x-slot name="metaDescription">
            {{-- {{ $metaDescription }} --}}
        </x-slot>
    </div>

    <script>
        function checkoutPage(payments, user) {
            return {
                payments: payments,
                user: user,
                orderNotes: '',
                selectedPaymentId: payments.find(payment => payment.active)?.id || payments[0].id,

                async changePaymentMethod(paymentId) {
                    this.selectedPaymentId = paymentId;
                    const response = await req.post('/api/change-payment', { paymentId: paymentId });

                    if (!response.success) {
                        console.error('Failed to change payment method');
                    }
                },

                async placeOrder() {
                    const orderData = {
                        name: this.user.name,
                        email: this.user.email,
                        comment: this.orderNotes,
                        id_payments: this.selectedPaymentId,
                    };

                    const response = await req.post('/api/send-checkout', orderData);
                    console.log(response)
                }
            };
        }
    </script>
</x-layout>
