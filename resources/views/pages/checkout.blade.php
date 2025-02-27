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
                                    <input type="text" class="form-control required" name="fname" id="fname" x-model="name">
                                </div>
                                <div class="col-sm-6">
                                    <label for="email">Email Address <span class="text-main-1">*</span>:</label>
                                    <input type="email" class="form-control required" name="email" id="email" x-model="email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-gap-2"></div>
                    <label for="notes">Order Notes:</label>
                    <textarea class="form-control" name="notes" id="notes" placeholder="Order Notes" rows="6" x-model="orderNotes"></textarea>
                </form>
                @if (Auth::user())
                    <div class="nk-gap"></div>
					<div class="bonus-container">
						<div class="h5 points-title points">
							На вашому бонусному рахунку <span>{{$user->points}}</span> балів
						</div>
						@if ($user->points > 0)
                            <input type="checkbox" name="subtract_points"
                            @if($subtractPoints) checked @endif
                            onchange="subtractPoints('{{ route('api-subtract-points', [], false) }}')"
                            class="subtract-points" />
                            Розрахуватися балами
                        @endif
					</div>
                    <div class="nk-gap"></div>
                @endif
                <x-checkout.promocode />
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
                name: (user && user.name) ? user.name : '',
                email: (user && user.email) ? user.email : '',
                orderNotes: '',
                selectedPaymentId: payments.find(payment => payment.active)?.id || payments[0].id,
                showPaypalButton: false,
                payPalId: '',

                async changePaymentMethod(paymentId) {
                    this.selectedPaymentId = paymentId;
                    const response = await req.post('/api/change-payment', { paymentId: paymentId });

                    if (!response.success) {
                        console.error('Failed to change payment method');
                    }
                },

                async placeOrder() {
                    const orderData = {
                        name: this.name,
                        email: this.email,
                        comment: this.orderNotes,
                        id_payments: this.selectedPaymentId,
                    };

                    const response = await req.post('/api/send-checkout', orderData);
                    //console.log(response)
                    console.log(response.data)

                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else if (response.data.paymentData && response.data.payment_id == 1) {
                        const formString = response.data.paymentData.original.form
                        const form = new DOMParser().parseFromString(formString, 'text/html').body.firstChild;  
                        document.body.appendChild(form);

                        form.submit();
                    } else if (response.data.paymentData && response.data.payment_id == 2) {
                        let form = document.createElement("form");
                        form.setAttribute("method", "POST");
                        form.setAttribute("action", 'https://secure.wayforpay.com/pay');
                        form.setAttribute("accept-charset", "utf-8");

                        let paymentData = response.data.paymentData.original; // Assuming response.data.paymentData contains all the fields

                        // Create input fields for all the payment data returned by the server
                        form.appendChild(this.createHiddenInput("merchantAccount", paymentData.merchantAccount));
                        form.appendChild(this.createHiddenInput("merchantDomainName", paymentData.merchantDomainName));
                        form.appendChild(this.createHiddenInput("merchantTransactionSecureType", paymentData.merchantTransactionSecureType));
                        form.appendChild(this.createHiddenInput("merchantSignature", paymentData.merchantSignature));
                        form.appendChild(this.createHiddenInput("apiVersion", paymentData.apiVersion));
                        form.appendChild(this.createHiddenInput("orderReference", paymentData.orderReference));
                        form.appendChild(this.createHiddenInput("orderDate", paymentData.orderDate));
                        form.appendChild(this.createHiddenInput("amount", paymentData.amount));
                        form.appendChild(this.createHiddenInput("currency", paymentData.currency));
                        form.appendChild(this.createHiddenInput("returnUrl", paymentData.returnUrl));
                        form.appendChild(this.createHiddenInput("serviceUrl", paymentData.serviceUrl)); // Optional, since it's the form's action URL
                        form.appendChild(this.createHiddenInput("merchantAuthType", 'SimpleSignature')); // Optional, since it's the form's action URL

                        for (let i = 0; i < paymentData.productName.length; i++) {
                            form.appendChild(this.createHiddenInput(`productName[]`, paymentData.productName[i]));
                            form.appendChild(this.createHiddenInput(`productPrice[]`, paymentData.productPrice[i]));
                            form.appendChild(this.createHiddenInput(`productCount[]`, paymentData.productCount[i]));
                        }

                        document.body.appendChild(form);

                        form.submit();
                    } else if (response.data.paymentData && (response.data.payment_id == 3 || response.data.payment_id == 4 || response.data.payment_id == 7 || response.data.payment_id == 8 || response.data.payment_id == 5)) {
                        window.location.href = response.data.paymentData.original.url;
                    } 
                },

                createHiddenInput(name, value) {
                    let input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", name);
                    input.setAttribute("value", value);
                    return input;
                },
            };
        }

        async function subtractPoints(route)
        {
            const subtractPointsInput = document.querySelector('input[name="subtract_points"]');

            const response = await req.post(route, {
                subtract_points: subtractPointsInput.checked ? 1 : 0,
            }, true)

            if (response.success) {
                document.querySelector('#checkout-info').innerHTML = response.data.checkout_info
            }
        }
    </script>
</x-layout>
