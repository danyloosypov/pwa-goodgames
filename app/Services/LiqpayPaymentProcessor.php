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
            'server_url' => route('handle-payment-callback'),
        ));

        return new JsonResponse([
            'form' => $form,
        ]);
    }

    public function processPayment(Request $request)
    {
        \Log::info('LiqPay callback request:', ['request' => $request->all()]);

        try {
            $data = $request->input('data');

            \Log::info('LiqPay data:', ['data' => $data]);


            // Decode the LiqPay data (it is base64-encoded JSON)
            $decodedData = json_decode(base64_decode($data), true);
            \Log::info('Decoded LiqPay data:', ['decodedData' => $decodedData]);

            // Find the corresponding order
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
                $order->save();

            } elseif ($status == 'failure') {
                $order->is_paid = false;
                $order->id_order_statuses = OrderStatus::FAILED;
                $order->save();

            } elseif ($status == 'reversed') {
                $order->is_paid = false;
                $order->id_order_statuses = OrderStatus::CANCELLED;
                $order->save();
            }

            $order->is_paid = false;
            $order->id_order_statuses = OrderStatus::FAILED;
            $order->save();

        } catch (InvalidCallbackRequestException $e) {
            Log::error('LiqPay callback error: ' . $e->getMessage());
        }
    }
}