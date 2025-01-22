<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NowPaymentsPaymentProcessor implements PaymentProcessorInterface
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('app.nowpayments.api_key'); // Assuming you're storing the API key in config/services.php
        $this->apiUrl = 'https://api-sandbox.nowpayments.io/v1/invoice'; // Sandbox API URL
    }

    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);

        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'price_amount' => $order->total, // Assuming order total is in fiat
            'price_currency' => 'usd', // uah not found
            'pay_currency' => 'btc',
            'order_id' => $order->id, // Unique order ID
            'order_description' => 'Payment for order #' . $order->id,
            'ipn_callback_url' => route('handle-payment-callback'),
            'success_url' => URL::signedRoute('thanks', ['order' => $order->id]),
            'cancel_url' => route('home'),
            'is_fee_paid_by_user' => true, // Optional: whether the user pays the fees
        ]);

        $data = $response->json();

        return response()->json([
            'url' => $data['invoice_url']
        ]);
    }

    public function processPayment(Request $request)
    {
        // Stripe-specific implementation
    }
}