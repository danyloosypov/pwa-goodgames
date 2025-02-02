<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use CoinGate\CoinGate;

class CoingatePaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);

        // In order, to use sandbox mode, you need to set second parameter to true.
        $client = new \CoinGate\Client(config('app.coingate.token'), true);

        $params = array(
            'order_id'          =>  $order->id,
            'price_amount'      =>  $order->total,
            'price_currency'    =>  'USD', // UAH не принимает
            'receive_currency'  =>  'USDT',
            'callback_url'      =>  route('handle-payment-callback', ['order_id' => $order->id]),
            'cancel_url'        =>  route('home'),
            'success_url'       =>  URL::signedRoute('thanks', ['order' => $order->id]),
            'title'             =>  'Order #' . $order->id,
            'description'       =>  '',
        );

        $order = $client->order->create($params);

        $order->coingate_id = $coingateOrder->id;
        $order->save();

        return response()->json([
            'url' => $order->payment_url,
        ]);
    }

    public function processPayment(Request $request)
    {
        try {
            // Get the posted data from CoinGate
            $data = $request->all();

            // Verify the CoinGate token to ensure the request is valid
            if (!$this->isValidCoinGateCallback($data)) {
                throw new \Exception('Invalid CoinGate callback signature.');
            }

            // Retrieve the order using the CoinGate order_id
            $orderId = $data['order_id'] ?? null;
            $order = Order::find($orderId);

            if (!$order) {
                throw new \Exception('Order not found.');
            }

            // Update the coingate_id in the order if not already set
            if (empty($order->coingate_id)) {
                $order->coingate_id = $data['id'];
            }

            // Process payment based on CoinGate status
            switch ($data['status']) {
                case 'paid':
                    $order->is_paid = true;
                    $order->id_order_statuses = OrderStatus::COMPLETED;
                    break;

                case 'invalid':
                case 'canceled':
                    $order->is_paid = false;
                    $order->id_order_statuses = OrderStatus::FAILED;
                    break;

                default:
                    throw new \Exception('Unknown payment status: ' . $data['status']);
            }

            // Save the order status
            $order->save();

            // Return success response to CoinGate
            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('CoinGate callback error: ' . $e->getMessage());

            // Return error response to CoinGate
            return response()->json(['status' => 'failure'], 400);
        }
    }

    /**
     * Validates the CoinGate callback.
     *
     * @param array $data
     * @return bool
     */
    private function isValidCoinGateCallback(array $data): bool
    {
        // Check if token matches
        $expectedToken = config('app.coingate.token');
        return $data['token'] === $expectedToken;
    }
}