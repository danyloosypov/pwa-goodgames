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
                    <span>Cart</span>
                </li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->
        <div class="container">
            <div class="nk-store nk-store-cart">
                <div class="table-responsive">
                    <!-- START: Products in Cart -->
                    <table class="table nk-store-cart-products">
                        <tbody>
                            <tr>
                                <td class="nk-product-cart-thumb">
                                    <a href="store-product.html" class="nk-image-box-1 nk-post-image">
                                        <img src="assets/images/product-2-xs.jpg" alt="However, I have reason" width="115">
                                    </a>
                                </td>
                                <td class="nk-product-cart-title">
                                    <h5 class="h6">Product:</h5>
                                    <div class="nk-gap-1"></div>
                                    <h2 class="nk-post-title h4">
                                        <a href="store-product.html">However, I have reason</a>
                                    </h2>
                                </td>
                                <td class="nk-product-cart-price">
                                    <h5 class="h6">Price:</h5>
                                    <div class="nk-gap-1"></div>
                                    <strong>₴ 32.00</strong>
                                </td>
                                <td class="nk-product-cart-quantity">
                                    <h5 class="h6">Quantity:</h5>
                                    <div class="nk-gap-1"></div>
                                    <div class="nk-form">
                                        <input type="number" class="form-control" value="1" min="1" max="21">
                                    </div>
                                </td>
                                <td class="nk-product-cart-total">
                                    <h5 class="h6">Total:</h5>
                                    <div class="nk-gap-1"></div>
                                    <strong>₴ 32.00</strong>
                                </td>
                                <td class="nk-product-cart-remove">
                                    <a href="#">
                                        <span class="ion-android-close"></span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="nk-product-cart-thumb">
                                    <a href="store-product.html" class="nk-image-box-1 nk-post-image">
                                        <img src="assets/images/product-4-xs.jpg" alt="She was bouncing" width="115">
                                    </a>
                                </td>
                                <td class="nk-product-cart-title">
                                    <h5 class="h6">Product:</h5>
                                    <div class="nk-gap-1"></div>
                                    <h2 class="nk-post-title h4">
                                        <a href="store-product.html">She was bouncing</a>
                                    </h2>
                                </td>
                                <td class="nk-product-cart-price">
                                    <h5 class="h6">Price:</h5>
                                    <div class="nk-gap-1"></div>
                                    <strong>₴ 20.00</strong>
                                </td>
                                <td class="nk-product-cart-quantity">
                                    <h5 class="h6">Quantity:</h5>
                                    <div class="nk-gap-1"></div>
                                    <div class="nk-form">
                                        <input type="number" class="form-control" value="1" min="1" max="21">
                                    </div>
                                </td>
                                <td class="nk-product-cart-total">
                                    <h5 class="h6">Total:</h5>
                                    <div class="nk-gap-1"></div>
                                    <strong>₴ 20.00</strong>
                                </td>
                                <td class="nk-product-cart-remove">
                                    <a href="#">
                                        <span class="ion-android-close"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- END: Products in Cart -->
                </div>
                <div class="nk-gap-1"></div>
                <a class="nk-btn nk-btn-rounded nk-btn-color-white float-right" href="#">Update Cart</a>
                <div class="clearfix"></div>
                <div class="nk-gap-2"></div>
                <div class="row vertical-gap">
                    <div class="col-md-6">
                        <!-- START: Calculate Shipping -->
                        <h3 class="nk-title h4">Calculate Shipping</h3>
                        <form action="#" class="nk-form">
                            <label for="country-sel">Country <span class="text-main-1">*</span>: </label>
                            <select name="country" class="form-control required" id="country-sel">
                                <option value="">Select a country...</option>
                            </select>
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
                            <a class="nk-btn nk-btn-rounded nk-btn-color-white float-right" href="#">Update Totals</a>
                        </form>
                        <!-- END: Calculate Shipping -->
                    </div>
                    <div class="col-md-6">
                        <!-- START: Cart Totals -->
                        <h3 class="nk-title h4">Cart Totals</h3>
                        <table class="nk-table nk-table-sm">
                            <tbody>
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
                        <!-- END: Cart Totals -->
                    </div>
                </div>
                <div class="nk-gap-2"></div>
                <a class="nk-btn nk-btn-rounded nk-btn-color-main-1 float-right" href="store-checkout.html">Proceed to Checkout</a>
                <div class="clearfix"></div>
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