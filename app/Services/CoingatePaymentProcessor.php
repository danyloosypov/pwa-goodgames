<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use CoinGate\CoinGate;

class CoingatePaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);

        // In order, to use sandbox mode, you need to set second parameter to true.
        $client = new \CoinGate\Client(config('app.coingate.token'), true);

        $params = array(
            'order_id'          =>  $order->id,
            'price_amount'      =>  $order->total,
            'price_currency'    =>  'USD', // UAH не принимает
            'receive_currency'  =>  'USDT',
            'callback_url'      =>  route('handle-payment-callback'),
            'cancel_url'        =>  route('home'),
            'success_url'       =>  URL::signedRoute('thanks', ['order' => $order->id]),
            'title'             =>  'Order #' . $order->id,
            'description'       =>  '',
        );

        $order = $client->order->create($params);

        return response()->json([
            'url' => $order->payment_url,
        ]);
    }

    public function processPayment(Request $request)
    {
        // Stripe-specific implementation
    }
}