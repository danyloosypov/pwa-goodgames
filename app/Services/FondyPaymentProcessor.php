<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FondyPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);
    }

    public function processPayment(Request $request)
    {
        // Stripe-specific implementation
    }
}