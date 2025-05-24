<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Cart\Traits\CartTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Order\Mail\BoughtCourse;
use Modules\Transaction\Services\TapPaymentService;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\Transaction\Services\PaymentService;
use Modules\Authentication\Foundation\Authentication;
use Modules\Transaction\Services\MyFatoorahPaymentService;
use Modules\Order\Http\Requests\Frontend\CreateOrderRequest;
use Modules\Order\Repositories\Frontend\OrderRepository as Order;
use Modules\Offer\Repositories\Frontend\OfferRepository as Offer;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository;

class OrderController extends ApiController
{
    use Authentication;
    use CartTrait;
    use PaymentTrait;


    public function __construct(public Order $order, public PaymentService $payment, public Offer $offer, public AuthenticationRepository $auth)
    {
    }

    public function create(Request $request)
    {
        $cart = $this->getCartContent();
        if (count($cart) > 0) {
            return $this->addOrder($request);
        }

        return $this->error(__('Your cart is impty'));
    }

    public function addOrder($data)
    {
        DB::beginTransaction();

        
        $user = $data->user();

        $data['user_id'] = $user->id;

        $order =  $this->order->create($data);
        $payment = $this->getPaymentGateway('upayment');
        DB::commit();

        $redirect = $payment->send($order, 'orders',$data->user_token,'api');

        if (isset($redirect['status'])) {

            if ($redirect['status'] == true) {
                return $this->response(['payment_ur' => $redirect['url']]);
            } else {
                return $this->error(__('Online Payment not valid now'));
            }
        }

        return $this->error('field');
    }

    public function success(Request $request)
    {
        $this->order->update($request['OrderID'], true);
        $this->clearCart();
        return $this->response([], __('Payment completed successfully'));
    }

    public function failed(Request $request)
    {
        return $this->error(__('Failed Payment , please try again'));
    }
    public function successUpayment(Request $request)
    {   
        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);
    }
}
