<?php

namespace App\Contracts;

interface PaymentProcessorFactoryInterface
{
    public function getProcessor(int $provider): PaymentProcessorInterface;
}