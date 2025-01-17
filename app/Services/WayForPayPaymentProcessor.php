<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;

class WayForPayPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(float $amount, string $currency, array $paymentDetails): array
    {
        // Stripe-specific implementation
    }

    public function processPayment(array $paymentData): array
    {
        // Stripe-specific implementation
    }
}