<div class="table-responsive">
    <table class="nk-table nk-table-sm">
        <thead class="thead-default">
            <tr>
                <th class="nk-product-cart-title">Product</th>
                <th class="nk-product-cart-total">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr class="nk-store-cart-totals-subtotal">
                <td> Subtotal </td>
                <td> ₴ {{$subtotal}} </td>
            </tr>
            @if (!empty($promocode))
                <tr class="nk-store-cart-totals-subtotal">
                    <td> Promocode </td>
                    <td> - {{$promocode}} ₴ </td>
                </tr>
            @endif
            @if (!empty($bonuses))
                <tr class="nk-store-cart-totals-subtotal">
                    <td> bonuses </td>
                    <td> - {{$bonuses}} ₴ </td>
                </tr>
            @endif
            @if (!empty($discount))
                <tr class="nk-store-cart-totals-subtotal">
                    <td> discount </td>
                    <td> - {{$discount}} ₴ </td>
                </tr>
            @endif
            <tr class="nk-store-cart-totals-total">
                <td> Total </td>
                <td> ₴ {{$total}} </td>
            </tr>
        </tbody>
    </table>
</div>