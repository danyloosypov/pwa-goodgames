<?php

namespace App\Shop\Fondy;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Fondy
{
    public function __construct()
    {
        \Cloudipsp\Configuration::setMerchantId(config('app.fondy.id'));
        \Cloudipsp\Configuration::setSecretKey(config('app.fondy.secret'));
    }

    public function getPaymentUrl(Order $order)
    {
        $data = [
            'order_desc' => 'Замовлення №' . $order->id,
            'currency' => 'UAH',
            'amount' => $order->total * 100,
            'response_url' => URL::signedRoute('thanks', ['order' => $order->id]),
            'server_callback_url' => route('handle-payment-callback'),
            'sender_email' => $order->email,
            'lang' => 'uk',
            'lifetime' => 36000,
        ];
        $url = \Cloudipsp\Checkout::url($data);
        $data = $url->getData();

        return $data['checkout_url'];
    }
}