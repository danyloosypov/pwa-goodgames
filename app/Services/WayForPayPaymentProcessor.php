<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Events\AssignBonusPointsEvent;
use App\Events\SendStatus;
use Illuminate\Support\Facades\Log;

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
        $serviceUrl = route('handle-payment-callback', ['order_id' => $order->id]);
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
        try {
            // Capture raw request body
            $rawBody = $request->getContent();

            // Attempt to decode the JSON payload from the request body
            $decodedData = json_decode($rawBody, true);

            // Extract necessary fields
            $merchantSignature = $decodedData['merchantSignature'] ?? null;
            $orderReference = $decodedData['orderReference'] ?? null;
            $transactionStatus = $decodedData['transactionStatus'] ?? null;
            $time = $decodedData['time'] ?? time();

            // Validate the received data
            if (!$merchantSignature || !$orderReference || !$transactionStatus) {
                throw new \Exception('Invalid callback data.');
            }

            // Find the order
            $order = Order::find($orderReference);
            if (!$order) {
                throw new \Exception('Order not found.');
            }

            // Process transaction status
            switch ($transactionStatus) {
                case 'Approved':
                    $order->is_paid = true;
                    $order->id_order_statuses = OrderStatus::COMPLETED;

                    $user = $order->user;
                    if ($user) {
                        $user->points -= $order->points_used;
                        $user->save();
                        event(new AssignBonusPointsEvent($user, $order));
                    }
                    break;
                case 'Declined':
                    $order->is_paid = false;
                    $order->id_order_statuses = OrderStatus::FAILED;
                    break;
                case 'Refunded':
                    $order->is_paid = false;
                    $order->id_order_statuses = OrderStatus::CANCELLED;
                    break;
                default:
                    throw new \Exception('Unknown transaction status.');
            }

            // Save order changes
            $order->save();

            // Generate response signature
            $responseSignature = $this->generateResponseSignature($orderReference, 'accept', $time);

            // Return a successful response with signature
            return response()->json([
                'orderReference' => $orderReference,
                'status' => 'accept',
                'time' => $time,
                'signature' => $responseSignature,
            ]);

        } catch (\Exception $e) {
            Log::error('WayForPay callback error: ' . $e->getMessage());

            // Generate error response signature
            $time = time();
            $responseSignature = $this->generateResponseSignature($orderReference ?? '', 'reject', $time);

            // Return an error response with signature
            return response()->json([
                'orderReference' => $orderReference ?? '',
                'status' => 'reject',
                'time' => $time,
                'signature' => $responseSignature,
            ]);
        }
    }

    private function generateResponseSignature(string $orderReference, string $status, int $time): string
    {
        // Формуємо рядок для підпису
        $signatureString = implode(';', [
            $orderReference,
            $status,
            $time
        ]);

        // Генеруємо підпис HMAC_MD5 з використанням секретного ключа
        return hash_hmac('md5', $signatureString, config('app.wayforpay.secret'));
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