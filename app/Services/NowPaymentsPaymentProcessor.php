<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Events\AssignBonusPointsEvent;
use App\Events\SendStatus;

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
            'ipn_callback_url' => route('handle-payment-callback', ['order_id' => $order->id]),
            'success_url' => URL::signedRoute('thanks', ['order' => $order->id]),
            'cancel_url' => route('home'),
            'is_fee_paid_by_user' => true, // Optional: whether the user pays the fees
        ]);

        $data = $response->json();

        $order->nowpayments_id = $data['id'];
        $order->save();

        return response()->json([
            'url' => $data['invoice_url']
        ]);
    }

    public function processPayment(Request $request)
    {
        $signature = $request->header('x-nowpayments-sig'); // Signature to verify the request authenticity
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        // Verify the signature to ensure the IPN request is legitimate
        $payload = $request->getContent();
        $computedSignature = hash_hmac('sha512', $payload, $this->apiKey);

        if ($signature !== $computedSignature) {
            Log::error('NOWPayments Callback: Invalid signature for order #' . $order->id);
            return response()->json(['error' => 'Invalid signature.'], 400);
        }

        $paymentStatus = $request->input('payment_status');

        if ($paymentStatus === 'finished') {
            $order->status = OrderStatus::COMPLETED; 
            $order->save();

            $user = $order->user;
            if ($user)
            {
                $user->points -= $order->points_used;
                $user->save();
                event(new AssignBonusPointsEvent($user, $order));
            }
            
            SendStatus::dispatch($order);

        } elseif ($paymentStatus === 'failed') {
            $order->status = OrderStatus::FAILED;
            $order->save();
        }

        return response()->json(['status' => 'success']);
    }
}