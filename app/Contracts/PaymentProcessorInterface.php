<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface PaymentProcessorInterface
{
    public function createPayment(int $orderId);
    public function processPayment(Request $request);
}
