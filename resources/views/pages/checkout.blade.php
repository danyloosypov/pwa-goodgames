<x-layout>

    <div class="nk-main">
        <!-- START: Breadcrumbs -->
        <div class="nk-gap-1"></div>
        <div class="container">
            <ul class="nk-breadcrumbs">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <span class="fa fa-angle-right"></span>
                </li>
                <li>
                    <a href="store.html">Store</a>
                </li>
                <li>
                    <span class="fa fa-angle-right"></span>
                </li>
                <li>
                    <a href="store-cart.html">Cart</a>
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
                        <div class="col-lg-6">
                            <div class="row vertical-gap">
                                <div class="col-sm-6">
                                    <label for="fname">First Name <span class="text-main-1">*</span>: </label>
                                    <input type="text" class="form-control required" name="fname" id="fname">
                                </div>
                                <div class="col-sm-6">
                                    <label for="lname">Last Name <span class="text-main-1">*</span>: </label>
                                    <input type="text" class="form-control required" name="lname" id="lname">
                                </div>
                            </div>
                            <div class="nk-gap-1"></div>
                            <label for="company">Company Name:</label>
                            <input type="text" class="form-control" name="company" id="company">
                            <div class="nk-gap-1"></div>
                            <div class="row vertical-gap">
                                <div class="col-sm-6">
                                    <label for="email">Email Address <span class="text-main-1">*</span>: </label>
                                    <input type="email" class="form-control required" name="email" id="email">
                                </div>
                                <div class="col-sm-6">
                                    <label for="phone">Phone <span class="text-main-1">*</span>: </label>
                                    <input type="tel" class="form-control required" name="phone" id="phone">
                                </div>
                            </div>
                            <div class="nk-gap-1"></div>
                            <label for="country-sel">Country <span class="text-main-1">*</span>: </label>
                            <select name="country" class="form-control required" id="country-sel">
                                <option value="">Select a country...</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="address">Address <span class="text-main-1">*</span>: </label>
                            <input type="text" class="form-control required" name="address" id="address">
                            <div class="nk-gap-1"></div>
                            <label for="city">Town / City <span class="text-main-1">*</span>: </label>
                            <input type="text" class="form-control required" name="city" id="city">
                            <div class="nk-gap-1"></div>
                            <div class="row vertical-gap">
                                <div class="col-sm-6">
                                    <label for="state">State / Country <span class="text-main-1">*</span>: </label>
                                    <input type="text" class="form-control required" name="state" id="state">
                                </div>
                                <div class="col-sm-6">
                                    <label for="zip">Postcode / ZIP <span class="text-main-1">*</span>: </label>
                                    <input type="tel" class="form-control required" name="zip" id="zip">
                                </div>
                            </div>
                            <div class="nk-gap-1"></div>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-indicator"></span> Ship to different address? </label>
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
                <div class="table-responsive">
                    <table class="nk-table nk-table-sm">
                        <thead class="thead-default">
                            <tr>
                                <th class="nk-product-cart-title">Product</th>
                                <th class="nk-product-cart-total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="nk-product-cart-title"> However, I have reason &times; 1 </td>
                                <td class="nk-product-cart-total"> ₴ 32.00 </td>
                            </tr>
                            <tr>
                                <td class="nk-product-cart-title"> She was bouncing &times; 1 </td>
                                <td class="nk-product-cart-total"> ₴ 20.00 </td>
                            </tr>
                            <tr class="nk-store-cart-totals-subtotal">
                                <td> Subtotal </td>
                                <td> ₴ 52.00 </td>
                            </tr>
                            <tr class="nk-store-cart-totals-shipping">
                                <td> Shipping </td>
                                <td> Free Shipping </td>
                            </tr>
                            <tr class="nk-store-cart-totals-total">
                                <td> Total </td>
                                <td> ₴ 52.00 </td>
                            </tr>
                        </tbody>
                    </table>
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