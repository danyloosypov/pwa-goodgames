<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WayForPayPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);

        $merchantAccount = config('app.wayforpay.login');
        $merchantDomainName = config('app.url');
        $merchantTransactionSecureType = 'AUTO';
        $merchantSignature = $this->generateSignature($order); // Signature generation function
        $apiVersion = 1;
        $currency = 'UAH';
        $returnUrl = URL::signedRoute('thanks', ['order' => $order->id]); // Success URL
        $serviceUrl = route('handle-payment-callback'); // Callback URL for the payment result
        $orderDate = \Carbon\Carbon::parse($order->date)->timestamp;
        $orderReference = $order->id;

        $productNames = $order->orderProducts->pluck('title')->toArray(); // Assuming an 'order' has 'products'
        $productPrices = $order->orderProducts->pluck('price')->toArray();
        $productCounts = array_fill(0, count($productNames), 1);
        $amount = $order->total;

        // Return JSON response with payment data
        return response()->json([
            'merchantAccount' => $merchantAccount,
            'merchantDomainName' => $merchantDomainName,
            'merchantTransactionSecureType' => $merchantTransactionSecureType,
            'merchantSignature' => $merchantSignature,
            'apiVersion' => $apiVersion,
            'orderReference' => $orderReference,
            'orderDate' => $orderDate,
            'amount' => $amount,
            'currency' => $currency,
            'productName' => $productNames,
            'productPrice' => $productPrices,
            'productCount' => $productCounts,
            'returnUrl' => $returnUrl,
            'serviceUrl' => $serviceUrl,
        ]);
    }

    public function processPayment(Request $request)
    {
        // Stripe-specific implementation
    }

    private function generateSignature(Order $order): string
    {
        $productNames = $order->orderProducts->pluck('title')->toArray(); // Get the product names
        $productPrices = $order->orderProducts->pluck('price')->toArray(); // Get the product prices
        $productCounts = array_fill(0, count($productNames), 1);
        
        $signatureString = implode(';', [
            config('app.wayforpay.login'),
            config('app.url'),
            $order->id,
            \Carbon\Carbon::parse($order->date)->timestamp,
            $order->total,
            'UAH',
            implode(';', $productNames), // Concatenate all product names with a semicolon
            implode(';', $productCounts), // Concatenate all product counts with a semicolon
            implode(';', $productPrices),
        ]);

        return hash_hmac('md5', $signatureString, config('app.wayforpay.secret'));
    }   
}