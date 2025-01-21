<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;


class StripePaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);

        Stripe::setApiKey(config('app.stripe.sk'));

        $lineItems = [];
        foreach ($order->orderProducts as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'uah', // Make sure to use the correct currency
                    'product_data' => [
                        'name' => $product->title, // Use product name from the order
                    ],
                    'unit_amount'  => (int) ($product->price * 100), // Convert to smallest currency unit
                ],
                'quantity'   => 1   , // Quantity of the product in the order
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'        => 'payment',
            'success_url' => URL::signedRoute('thanks', ['order' => $order->id]),
            'cancel_url'  => route('checkout'),
        ]);

        $order->stripe_session_id = $session->id;
        $order->save();

        return response()->json([
            'url' => $session->url,
        ]);
    }

    public function processPayment(Request $request)
    {
        // Stripe-specific implementation
    }
}