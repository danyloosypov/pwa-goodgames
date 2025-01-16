<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;

class LiqpayPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(float $amount, string $currency, array $paymentDetails): array
    {
        //Liqpay
        /*

        $order = Order::findOrFail($orderId);

        $prerequisites = LiqPay::getCheckoutFormPrerequisites([
            'amount' => $order->amount,
            'description' => $order->description,
            'order_id' => $order->id,
            'result_url' => route('web.checkout'),
            'server_url' => route('api.liqpay_callback'), // The url that wil be used for order webhook notification
            'currency' => $order->currency, // Optional. If not set - default currency will be used.
        ]);

        return new JsonResponse([
            'action' => $prerequisites->getAction(),
            'data' => $prerequisites->getData(),
            'signature' => $prerequisites->getSignature(),
        ]);

        */
    }

    public function processPayment(array $paymentData): array
    {
        // Stripe-specific implementation
    }
}