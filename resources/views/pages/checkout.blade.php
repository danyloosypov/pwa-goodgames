<x-layout>

    <div class="nk-main">
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
                        <span class="text-main-1">Billing</span> Details </span>
                </h3>
                <!-- START: Billing Details -->
                <div class="nk-gap"></div>
                <form action="#" class="nk-form">
                    <div class="row vertical-gap">
                        <div class="col-lg-12">
                            <div class="row vertical-gap">
                                <div class="col-sm-4">
                                    <label for="fname">First Name <span class="text-main-1">*</span>: </label>
                                    <input type="text" class="form-control required" name="fname" id="fname">
                                </div>
                                <div class="col-sm-4">
                                    <label for="lname">Last Name <span class="text-main-1">*</span>: </label>
                                    <input type="text" class="form-control required" name="lname" id="lname">
                                </div>
                                <div class="col-sm-4">
                                    <label for="email">Email Address <span class="text-main-1">*</span>: </label>
                                    <input type="email" class="form-control required" name="email" id="email">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END: Billing Details -->
                <div class="nk-gap-2"></div>
                <form action="#" class="nk-form">
                    <div class="nk-gap-1"></div>
                    <label for="notes">Order Notes:</label>
                    <textarea class="form-control" name="notes" id="notes" placeholder="Order Notes" rows="6"></textarea>
                </form>
                <!-- START: Order Products -->
                <div class="nk-gap-3"></div>
                <h3 class="nk-decorated-h-2">
                    <span>
                        <span class="text-main-1">Your</span> Order </span>
                </h3>
                <div class="nk-gap"></div>
                <div class="" id="checkout-products">
                    <x-checkout.products />
                </div>
                <div id="checkout-info">
                    <x-checkout.info />
                </div>
                <!-- END: Order Products -->
                <div class="nk-gap-2"></div>
                <a class="nk-btn nk-btn-rounded nk-btn-color-main-1" href="#">Place Order</a>
            </div>
        </div>
        <div class="nk-gap-2"></div>

    <x-slot name="metaTitle">
        {{-- {{ $metaTitle }} --}}
    </x-slot>

    <x-slot name="metaDescription">
        {{-- {{ $metaDescription }} --}}
    </x-slot>

</x-layout>