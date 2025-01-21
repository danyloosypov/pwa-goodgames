<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Contracts\PaymentProcessorFactoryInterface;
use App\Services\StripePaymentProcessor;
use App\Services\PayPalPaymentProcessor;

class PaymentProcessorFactory implements PaymentProcessorFactoryInterface
{
    public function getProcessor(int $provider): PaymentProcessorInterface
    {
        switch ($provider) {
            case 1:
                return new LiqpayPaymentProcessor(); 
            case 2:
                return new WayForPayPaymentProcessor(); 
            case 3:
                return new FondyPaymentProcessor(); 
            case 4:
                return new StripePaymentProcessor(); 
            case 5:
                return new PayPalPaymentProcessor(); 
            case 6:
                return new SquarePaymentProcessor(); 
            case 7:
                return new CoingatePaymentProcessor(); 
            case 8:
                return new NowPaymentsPaymentProcessor(); 
            default:
                throw new \Exception("Unsupported payment provider: $provider");
        }
    }
}