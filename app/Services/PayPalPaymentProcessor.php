<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class PayPalPaymentProcessor implements PaymentProcessorInterface
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $currency;

    public function __construct()
    {
        $this->baseUrl = config('app.paypal.base_url');
        $this->clientId = config('app.paypal.client_id');
        $this->clientSecret = config('app.paypal.client_secret');
        $this->currency = config('app.paypal.currency');
    }

    /**
     * Create a new payment.
     *
     * @param int $orderId
     * @return JsonResponse
     */
    public function createPayment(int $orderId): JsonResponse
    {
        $order = Order::findOrFail($orderId);

        // Get PayPal access token
        $accessToken = $this->getAccessToken();

        // Create the payment with PayPal
        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $this->currency,
                            'value' => $order->total,
                        ],
                        'description' => 'Order #' . $order->id,
                    ],
                ],
                'application_context' => [
                    'return_url' => route('thanks.paypal', ['order' => $order->id]),
                    'cancel_url' => route('home'),
                ],
            ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Unable to create payment.'], 500);
        }

        $responseBody = json_decode($response->body());

        // Find the approval link in the response
        $approvalLink = collect($responseBody->links)->firstWhere('rel', 'approve')->href ?? null;

        if (!$approvalLink) {
            return response()->json(['error' => 'Approval link not found.'], 500);
        }

        return response()->json([
            'url' => $approvalLink,
        ]);
    }

    /**
     * Process a payment after the customer has approved it.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function processPayment(Request $request): JsonResponse
    {
        /*$orderId = $request->input('orderId');
        $paypalOrderId = $request->input('token');

        $accessToken = $this->getAccessToken();

        // Capture the payment
        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . "/v2/checkout/orders/{$paypalOrderId}/capture");

        if ($response->failed()) {
            return response()->json(['error' => 'Payment failed to capture.'], 500);
        }

        $order = Order::findOrFail($orderId);
        $order->status = 'paid';
        $order->save();

        return response()->json(['success' => 'Payment processed successfully.']);*/
    }

    /**
     * Get PayPal access token.
     *
     * @return string
     */
    protected function getAccessToken(): string
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
            ->post($this->baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            throw new \Exception('Unable to get access token from PayPal.');
        }

        return $response->json()['access_token'];
    }
}
