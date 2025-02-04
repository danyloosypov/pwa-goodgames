<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Fondy;
use Illuminate\Support\Facades\Log;
use App\Events\AssignBonusPointsEvent;
use App\Events\SendStatus;

class FondyPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(int $orderId)
    {
        $order = Order::find($orderId);

        return response()->json([
            'url' => Fondy::getPaymentUrl($order),
        ]);
    }

    public function processPayment(Request $request)
    {
        try {
            // Get the posted data from Fondy
            $data = $request->all();

            Log::info('WayForPay callback important data:', [
                'data' => $data,
                'order_id' => $data['order_id'],
                'isValidFondySignature' => $this->isValidFondySignature($data),
            ]);

            // Validate the Fondy signature
            if (!$this->isValidFondySignature($data)) {
                throw new \Exception('Invalid signature.');
            }

            // Retrieve the order using the order_id or order_reference from the request
            $orderId = $data['order_id'] ?? null;
            $order = Order::find($orderId);

            if (!$order) {
                throw new \Exception('Order not found.');
            }

            // Process payment based on Fondy transaction status
            switch ($data['order_status']) {
                case 'approved':
                    $order->is_paid = true;
                    $order->id_order_statuses = OrderStatus::COMPLETED;

                    $user = $order->user;
                    if ($user)
                    {
                        $user->points -= $order->points_used;
                        $user->save();
                        event(new AssignBonusPointsEvent($user, $order));
                    }
                    
                    SendStatus::dispatch($order);
                    break;

                case 'declined':
                    $order->is_paid = false;
                    $order->id_order_statuses = OrderStatus::FAILED;
                    break;

                case 'expired':
                    $order->is_paid = false;
                    $order->id_order_statuses = OrderStatus::CANCELLED;
                    break;

                case 'processing':
                    // Order is still being processed, no status change yet
                    break;

                default:
                    throw new \Exception('Unknown order status: ' . $data['order_status']);
            }

            // Save the order status
            $order->save();

            // Return success response to Fondy
            return response()->json(['response_status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Fondy callback error: ' . $e->getMessage());

            // Return error response to Fondy
            return response()->json(['response_status' => 'failure'], 400);
        }
    }

    /**
     * Validates the Fondy signature.
     *
     * @param array $data
     * @return bool
     */
    private function isValidFondySignature(array $data): bool
    {
        // The signature is calculated using all response fields, sorted by keys and concatenated with '|' character.
        $signature = $data['signature'] ?? null;
        unset($data['signature']); // Remove signature from the data for validation

        ksort($data); // Sort data by keys

        $signatureString = implode('|', $data);
        $calculatedSignature = sha1(config('app.fondy.secret') . '|' . $signatureString);

        return $signature === $calculatedSignature;
    }
}