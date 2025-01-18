<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Liqpay;

class LiqpayPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);

        $form = Liqpay::cnbForm(array(
            'action' => 'pay',
            'amount' => $order->total,
            'currency' => 'UAH',
            'description' => 'Замовлення № ' . $order->id,
            'order_id' => $order->id,
            'version' => '3',
            'result_url' => URL::signedRoute('thanks', ['order' => $order->id]),
            'server_url' => route('api-liqpay-callback'),
        ));

        return new JsonResponse([
            'form' => $form,
        ]);
    }

    public function processPayment(array $paymentData): array
    {
        // Stripe-specific implementation
    }
}