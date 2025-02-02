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
        $event = $request->input('event_type');
        $resource = $request->input('resource');

        switch ($event) {
            case 'PAYMENT.CAPTURE.COMPLETED':
                
                break;

            case 'PAYMENT.CAPTURE.DECLINED':
                
                break;

            case 'PAYMENT.CAPTURE.PENDING':
                
                break;

            case 'PAYMENT.CAPTURE.REFUNDED':
                
                break;

            case 'PAYMENT.CAPTURE.REVERSED':
                
                break;

            default:
                return response()->json(['message' => 'Event not handled'], 200);
        }

        return response()->json(['message' => 'Webhook handled successfully'], 200);
    }

    public function createWebhook(): JsonResponse
    {
        // Get PayPal access token
        $accessToken = $this->getAccessToken();

        // Define the webhook URL and event types you want to subscribe to
        $webhookData = [
            'url' => route('paypal.webhook'),  // Replace with your actual webhook handling route
            'event_types' => [
                ['name' => 'PAYMENT.CAPTURE.DECLINED'],
                ['name' => 'PAYMENT.CAPTURE.COMPLETED'],
                ['name' => 'PAYMENT.CAPTURE.PENDING'],
                ['name' => 'PAYMENT.CAPTURE.REFUNDED'],
                ['name' => 'PAYMENT.CAPTURE.REVERSED'],
                // You can add more event types if needed
            ],
        ];

        // Create the webhook via PayPal API
        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . '/v1/notifications/webhooks', $webhookData);

        // Handle failure
        if ($response->failed()) {
            return response()->json(['error' => 'Unable to create PayPal webhook.'], 500);
        }

        return response()->json(['message' => 'Webhook created successfully.']);
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
