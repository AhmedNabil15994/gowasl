<?php

namespace Modules\Order\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Addon\Entities\Addon;
use Modules\Area\Entities\City;
use Modules\Area\Repositories\Frontend\AreaRepository;
use Modules\Authentication\Http\Controllers\Frontend\RegisterController;
use Modules\Authentication\Http\Requests\Frontend\RegisterDuringOrderRequest;
use Modules\Authentication\Http\Requests\Frontend\RegisterRequest;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository;
use Modules\Category\Entities\Category;
use Modules\Meal\Entities\DailyMeal;
use Modules\Order\Entities\Suspension;
use Modules\Order\Entities\OrderAddress;
use Modules\Order\Entities\OrderDetails;
use Modules\Order\Http\Requests\Frontend\CreateOrderRequest;
use Modules\Order\Repositories\Frontend\OrderRepository;
use Modules\Package\Entities\Package;
use Modules\Package\Http\Requests\Frontend\PackageSubscribeRequest;
use Modules\Package\Repositories\Frontend\PackageRepository;
use Modules\Transaction\Services\MyFatoorahPaymentService;
use Modules\Transaction\Services\PaymentService;
use Modules\Transaction\Services\TapPaymentService;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\User\Entities\PasswordReset;
use Modules\User\Entities\User;

class OrderController extends Controller
{
    use PaymentTrait;
    public  $package;
    public  $area;
    public  $order;
    public  $payment;
    public function __construct( PaymentService $payment, OrderRepository $order)
    {
//        $this->package = $package;
//        $this->order = $order;
        $this->payment = $payment;
        $this->order = $order;
    }

    public function createView()
    {
        return view('order::frontend.checkout');
    }

    public function getOrderDetails(Request $request) {
        session()->forget('discount');
        $package = Package::find($request->package_id);
        return [
            'title' =>   $package->title,
            'image' =>   $package->getFirstMediaUrl('images'),
            'price' =>   $request->duration_type == 1 ? $package->monthly_price : $package->annual_price,
            'start_date'    => date('Y-m-d'),
            'end_date'      => date('Y-m-d',strtotime('+'.($request->duration_type == 1 ? 1 : 12).' months',strtotime(  date('Y-m-d ')) )),
        ];
    }

    public function payOrder(CreateOrderRequest $request)
    {
        $registerRequest = App::make(RegisterRequest::class, [
            'name' => $request->name,
            'email'  => $request->email,
            'mobile'  => $request->mobile,
            'password'  => $request->password,
            'confirm_password'  => $request->confirm_password,
        ]);

        $check = (new RegisterController(new AuthenticationRepository(new User(),new PasswordReset())))->registerDuringOrder($registerRequest);
        if($check){
            $request->merge(['user_id'=>auth()->id()]);
        }

        $order = $this->order->create($request);

        if(!$request['payment_method']){
            $request['payment_method'] = 'upayment';
//            return back()->withInput()->withErrors(['payment' => __('order::frontend.checkout.invalid_payment')]);
        }

        $payment = $this->getPaymentGateway($request['payment_method']);
        $redirect = $payment->send($order, 'orders');

        if (isset($redirect['status'])) {
            if ($redirect['status'] == true) {
                $order->transactions()->create([
                    'method' => $request['payment_method'],
                    'result' => null,
                ]);
                return redirect()->away($redirect['url']);
            } else {
                return back()->withInput()->withErrors(['payment' => __('order::frontend.checkout.payment_error')]);
            }
        }

        return 'failed';
    }

    public function success(Request $request)
    {
        $order = $this->order->findById($request['OrderID']);
        if (!$order) {
            return false;
        }
        $this->payment->setTransactions($request,$order);

        $this->order->update($request, true);
        return redirect()->route('frontend.orders.completed',$order->id);
    }

    public function failed(Request $request)
    {
        $order = $this->order->findById($request['OrderID']);
        if (!$order) {
            return false;
        }
        $order->update(['order_status_id'=>2]);
        return redirect()->route('frontend.cart.checkout')->with([
            'status'    => 'danger',
            'msg'      => __('Failed Payment , please try again'),
        ]);
    }

    public function successTap(Request $request)
    {
        $data = (new TapPaymentService())->getTransactionDetails($request);

        $request = PaymentTrait::buildTapRequestData($data, $request);
        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);

    }

    public function successUpayment(Request $request)
    {
        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);
    }

    public function myFatoorahCallBack(Request $request)
    {
        $data = (new MyFatoorahPaymentService())->GetPaymentStatus($request->paymentId , 'paymentId');

        $request = PaymentTrait::buildMyFatoorahRequestData($data, $request);

        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);
    }

    public function orderCompleted()
    {
        return redirect()->to(route('dashboard.channels.index'));
    }
}
