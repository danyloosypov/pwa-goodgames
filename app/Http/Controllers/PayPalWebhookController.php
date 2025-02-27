<?php

namespace App\Http\Controllers;

use App\Services\PayPalPaymentProcessor;
use Illuminate\Http\JsonResponse;

class PayPalWebhookController extends Controller
{
    protected $paymentProcessor;

    // Inject PayPalPaymentProcessor into the controller
    public function __construct(PayPalPaymentProcessor $paymentProcessor)
    {
        $this->paymentProcessor = $paymentProcessor;
    }

    public function register()
    {
        return $this->paymentProcessor->createWebhook();
    }

    /**
     * Handle the PayPal payment process after approval.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function processPayment(Request $request): JsonResponse
    {
        // Use the payment processor to process the payment
        return $this->paymentProcessor->processPayment($request);
    }
}
