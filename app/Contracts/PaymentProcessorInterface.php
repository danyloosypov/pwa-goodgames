<?php

namespace App\Contracts;

interface PaymentProcessorInterface
{
    public function createPayment(float $amount, string $currency, array $paymentDetails): array;
    public function processPayment(array $paymentData): array;
}
