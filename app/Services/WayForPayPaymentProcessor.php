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
            // Отримуємо дані запиту
            $response = $request->all();

            // Витягуємо необхідні поля
            $merchantSignature = $response['merchantSignature'] ?? null;
            $orderReference = $response['orderReference'] ?? null;
            $transactionStatus = $response['transactionStatus'] ?? null;
            $time = $response['time'] ?? time();

            if (!$merchantSignature || !$orderReference || !$transactionStatus) {
                throw new \Exception('Invalid callback data.');
            }

            // Отримуємо замовлення
            $order = Order::find($orderReference);

            if (!$order) {
                throw new \Exception('Order not found.');
            }

            // Перевіряємо підпис
            if (!$this->verifySignature($response, $order)) {
                throw new \Exception('Invalid signature.');
            }

            // Обробляємо статус транзакції
            switch ($transactionStatus) {
                case 'Approved':
                    $order->is_paid = true;
                    $order->id_order_statuses = OrderStatus::COMPLETED;
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

            $order->save();

            // Генеруємо підпис для відповіді
            $responseSignature = $this->generateResponseSignature($orderReference, 'accept', $time);

            // Повертаємо відповідь з підписом
            return response()->json([
                'orderReference' => $orderReference,
                'status' => 'accept',
                'time' => $time,
                'signature' => $responseSignature,
            ]);

        } catch (\Exception $e) {
            Log::error('WayForPay callback error: ' . $e->getMessage());

            // Генеруємо підпис для відповіді з помилкою
            $time = time();
            $responseSignature = $this->generateResponseSignature($orderReference ?? '', 'reject', $time);

            // Повертаємо помилкову відповідь з підписом
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

    private function verifySignature(array $response, Order $order): bool
    {
        // Build the signature string in the same way as it was generated
        $productNames = $order->orderProducts->pluck('title')->toArray(); // Get product names
        $productPrices = $order->orderProducts->pluck('price')->toArray(); // Get product prices
        $productCounts = array_fill(0, count($productNames), 1);

        $signatureString = implode(';', [
            config('app.wayforpay.login'),
            $response['orderReference'],
            $response['amount'],
            $response['currency'],
            implode(';', $productNames),
            implode(';', $productCounts),
            implode(';', $productPrices),
        ]);

        // Generate the signature with the secret key
        $expectedSignature = hash_hmac('md5', $signatureString, config('app.wayforpay.secret'));

        // Compare the expected signature with the one sent in the response
        return $expectedSignature === $response['merchantSignature'];
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