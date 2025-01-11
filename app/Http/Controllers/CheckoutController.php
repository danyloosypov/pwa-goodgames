<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Store;
use App\Models\Payment;
use App\Models\PaymentsType;
use App\Models\UserAddress;
use App\Models\OrdersStatus;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Http\Requests\CheckoutSendRequest;
use App\Events\SendOrder;
use App\Events\SendStatus;
use App\View\Components\Inc\Cart\CartCreditInfo;
use App\View\Components\Inc\Cart\CartInfo;
use App\View\Components\Inc\Cart\Promocode as CartPromocode;
use App\Services\CheckoutService;
use App\View\Components\Inputs\InputselectItems;
use Illuminate\Support\Facades\URL;
use Single;
use Auth;
use SEO;
use CartPrice;
use Cart;
use Promocode;

class CheckoutController extends Controller
{
    public function page(/*CheckoutService $checkoutService*/)
    {
        SEO::robots("noindex, nofollow");

        $user = Auth::user();
        
        /*$payments = $checkoutService->getPayments();
		$payment = $payments->where('active', true)->first();

        if (empty($payment)) {
            $payment = $payments->first();
        }

        $paymentsTypes = Payment::get();*/

        return view("pages.checkout", [
            /*"single" => $single,
            "payments" => $payments,
            "payment" => $payment,
            "user" => $user,*/
        ]);
    }

    public function send(CheckoutSendRequest $r)
    {
        $data = $r->validated();

        if (!Cart::count()) {
            return $this->error();
        }

        $promocode = Promocode::get();

        $data["subtotal_price"] = CartPrice::subtotal();
        $data["id_promocode"] = $promocode->id ?? 0;
        $data["promocode_price"] = -CartPrice::promocode();
        $data["discount_price"] = -CartPrice::discount();
        $data["user_discount_price"] = -CartPrice::userDiscount();
        $data["delivery_price"] = CartPrice::delivery($data["id_delivery"]);
        $data["total_price"] = CartPrice::total($data["delivery_price"]);
        $data["date"] = date("Y-m-d H:i:s");
        $data["id_users"] = Auth::user()->id ?? 0;
        $data["warranty"] = "";
        $data["check"] = "";
        $data["id_orders_status"] = OrdersStatus::NEW;

        $data["parts_price"] = 0;
        if ($data["id_payments"] == Payment::CREDIT) {
            $parts = $data["parts"] == 0 ? 1 : $data["parts"];
            $data["parts_price"] = round($data["total_price"] / $parts, 2);
        }

        $order = new Order($data);
        $order->save();

        foreach (Cart::products() as $product) {
            $orderProduct = new OrdersProduct();

            $orderProduct->title = $product->title;
            $orderProduct->slug = $product->slug;
            $orderProduct->image = $product->image;
            $orderProduct->price = $product->price;
            $orderProduct->count = $product->qty;
            $orderProduct->id_orders = $order->id;
            $orderProduct->id_products = $product->id;

            $orderProduct->save();
        }

        session()->put("payBtn", "");
        /*if ($data['id_payments'] == Payment::ONLINE) {

			$payBtn = Liqpay::cnbForm(array(
				'action' => 'pay',
				'amount' => $order->total_price,
				'currency' => 'UAH',
				'description' => (Lang::get() == 'ru' ? 'Заказ' : 'Замовлення').' № ' . $order->id,
				'order_id' => $order->id,
				'version' => '3',
				'result_url' => route('thanks', ['order' => $order->id, 'online' => 1], true),
				'status' => '',
			)).'<hr>';

			session()->put('payBtn', $payBtn);
		}*/

        SendOrder::dispatch($order);
        SendStatus::dispatch($order);

        Cart::clear();
        Promocode::setUsed();

        session()->forget("delivery");
        session()->forget("payment_id_banks");
        session()->forget("payment_parts");
        session()->forget("payment_id");

        /*if ($data['id_payments'] == Payment::CREDIT) {

			if ($data['id_banks'] == Bank::PRIVATBANK || $data['id_banks'] == Bank::MOMENTAL) {

				$privat24Link = $privatService->createPaymentLink($order);

			} elseif ($data['id_banks'] == Bank::MONOBANK) {

				$responseMonobank = $monobankService->createOrder($order);
			}
		}*/

		return response()->json([
            'redirect' => URL::signedRoute('thanks', ['order' => $order->id], now()->addMinutes(30)),
		]);
    }

    public function thanks(Request $r, Order $orderModel)
    {
        $id = $r->get("order");

        $order = $orderModel->findById($id);

        if (empty($order)) {
            abort(404);
        }

        $single = Single::get("thanks");

        return view("pages.thanks", [
            "order" => $order,
            "single" => $single,
        ]);
    }
}
