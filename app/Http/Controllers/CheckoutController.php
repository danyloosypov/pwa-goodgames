<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\OrderStatus;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Http\Requests\CheckoutSendRequest;
use App\Events\SendOrder;
use App\Events\SendStatus;
use App\View\Components\Inc\Cart\CartCreditInfo;
use App\View\Components\Inc\Cart\CartInfo;
use App\View\Components\Inc\Cart\Promocode as CartPromocode;
use App\View\Components\Inputs\InputselectItems;
use Illuminate\Support\Facades\URL;
use Single;
use Auth;
use SEO;
use CartPrice;
use Cart;
use Promocode;
use UserDiscount;
use App\Contracts\PaymentProcessorFactoryInterface;
use DigitalThreads\LiqPay\Exceptions\InvalidCallbackRequestException;
use DigitalThreads\LiqPay\LiqPay;
use App\Events\AssignBonusPointsEvent;

class CheckoutController extends Controller
{
    protected $paymentProcessorFactory;

    public function __construct(PaymentProcessorFactoryInterface $paymentProcessorFactory)
    {
        $this->paymentProcessorFactory = $paymentProcessorFactory;
    }

    public function page(Payment $paymentsModel)
    {
        SEO::robots("noindex, nofollow");

        $user = Auth::user();

        $payments = $paymentsModel->get();

		$payments = $payments->filter(function ($payment) {  
            if ($payment->id == session()->get('payment_id', Payment::LIQPAY)) {
                $payment->active = true;
            }
    
            return true;
        });
        
		$payment = $payments->where('active', true)->first();

        if (empty($payment)) {
            $payment = $payments->first();
        }

        [$subtractPoints, $availableBonuses] = UserDiscount::getPoints();

        return view("pages.checkout", [
            "payments" => $payments,
            "payment" => $payment,
            "user" => $user,
            "subtractPoints" => $subtractPoints,
            /*"single" => $single,
            */
        ]);
    }

    public function send(CheckoutSendRequest $r)
    {
        $data = $r->validated();

        $promocode = Promocode::get();

        $data["subtotal"] = CartPrice::subtotal();
        $data["id_promocode"] = $promocode->id ?? 0;
        $data["promocode_price"] = CartPrice::promocode();
        $data["discount_price"] = CartPrice::discount();
        $data['points_used'] = CartPrice::usedBonuses();
        $data["total"] = CartPrice::total();
        $data["is_paid"] = false;
        $data["date"] = date("Y-m-d H:i:s");
        $data["id_users"] = Auth::user()->id ?? 0;
        $data["id_order_statuses"] = OrderStatus::NEW;

        $order = new Order($data);
        $order->save();

        foreach (Cart::products() as $product) {
            $orderProduct = new OrderProduct();

            $orderProduct->title = $product->title;
            $orderProduct->image = $product->image;
            $orderProduct->price = $product->price;
            $orderProduct->id_orders = $order->id;
            $orderProduct->id_products = $product->id;

            $orderProduct->save();
        }

        SendOrder::dispatch($order);

        $paymentProcessor = $this->paymentProcessorFactory->getProcessor($data['id_payments']);

        $response = $paymentProcessor->createPayment($order->id);

        //Cart::clear();
		Promocode::setUsed();

        session()->forget("payment_id");

        return response()->json([
            'payment_id' => $data['id_payments'],
            'paymentData' => $response,
        ]);
    }

    public function changePayment(Request $r)
	{
		$paymentId = $r->get('paymentId', 0);
		$paymentMethod = Payment::find($paymentId);
        if (!$paymentMethod) {
            return response()->json([
                'success' => false,
                'message' => 'Payment method not found.',
            ], 404);
        }

        // Save the payment method in the session
        session()->put('payment_id', $paymentId);

        return response()->json([
            'success' => true,
            'message' => 'Payment method updated successfully.',
        ]);
	}

    public function thanks(Request $r, Order $orderModel)
    {
        $id = $r->get("order");

        $order = Order::find($id);

        if (empty($order)) {
            abort(404);
        }

        //TODO: move to payment callback
        $user = $order->user;
		if ($user)
		{
			$user->points -= $order->points_used;
			$user->save();
			event(new AssignBonusPointsEvent($user, $order));
		}
        
        SendStatus::dispatch($order);
        //TODO

        //$single = Single::get("thanks");

        return view("pages.thanks", [
            "order" => $order,
            //"single" => $single,
        ]);
    }

    public function handlePaymentCallback(Requrest $request)
    {
        $paymentId = session()->get('payment_id', 0);

        if (!empty($paymentId)) {
            $paymentProcessor = $this->paymentProcessorFactory->getProcessor($data['id_payments']);

            $paymentProcessor->processPayment($request);
        }
    }
}
