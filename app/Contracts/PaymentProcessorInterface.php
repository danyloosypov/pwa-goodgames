<?php

namespace App\Contracts;

interface PaymentProcessorInterface
{
    public function createPayment(int $orderId);
    public function processPayment(array $paymentData);
}
