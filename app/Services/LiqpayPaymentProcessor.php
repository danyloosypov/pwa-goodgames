<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Liqpay;

class LiqpayPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);

        $form = Liqpay::cnbForm(array(
            'action' => 'pay',
            'amount' => $order->total,
            'currency' => 'UAH',
            'description' => 'Замовлення № ' . $order->id,
            'order_id' => $order->id,
            'version' => '3',
            'result_url' => URL::signedRoute('thanks', ['order' => $order->id]),
            'server_url' => route('handle-payment-callback', ['order_id' => $order->id]),
        ));

        return new JsonResponse([
            'form' => $form,
        ]);
    }

    public function processPayment(Request $request)
    {
        try {
            $data = $request->input('data');

            // Decode the LiqPay data (it is base64-encoded JSON)
            $decodedData = json_decode(base64_decode($data), true);

            $orderId = $decodedData['order_id'] ?? null;
            $status = $decodedData['status'] ?? null;

            if (!$orderId || !$status) {
                throw new InvalidCallbackRequestException('Invalid data in the LiqPay callback.');
            }

            $order = Order::find($orderId);

            if (!$order) {
                throw new InvalidCallbackRequestException('Order not found.');
            }

            // Handle the payment status
            if ($status == 'success') {
                $order->is_paid = true;
                $order->id_order_statuses = OrderStatus::COMPLETED;

            } elseif ($status == 'failure') {
                $order->id_order_statuses = OrderStatus::FAILED;

            } elseif ($status == 'reversed') {
                $order->id_order_statuses = OrderStatus::CANCELLED;
            }

            $order->liqpay_id = $decodedData['payment_id'];

            $order->is_paid = false;
            $order->id_order_statuses = OrderStatus::FAILED;
            $order->save();

        } catch (InvalidCallbackRequestException $e) {
            Log::error('LiqPay callback error: ' . $e->getMessage());
        }
    }
}