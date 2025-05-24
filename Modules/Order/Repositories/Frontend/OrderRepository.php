<?php

namespace Modules\Order\Repositories\Frontend;

use Auth;
use CartTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Modules\Channel\Http\Requests\Dashboard\ChannelRequest;
use Modules\Channel\Repositories\Dashboard\ChannelRepository;
use Modules\Coupon\Http\Controllers\Frontend\CouponController;
use Modules\Course\Entities\Note;
use Modules\Offer\Entities\Offer;
use Modules\Order\Entities\Address;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Course\Notifications\NewCourseEnrollmentNotification;
use Modules\Order\Entities\OrderItem;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Traits\OrderCalculationTrait;
use Modules\Package\Entities\PackagePrice;

class OrderRepository
{
    use OrderCalculationTrait;

    public function __construct(Order $order, OrderStatus $status, ChannelRepository $channel,Address $address)
    {
        $this->channel = $channel;
        $this->order = $order;
        $this->status = $status;
        $this->address = $address;
    }

    public function getAllByUser()
    {
        return $this->order->where('user_id', auth()->id())->get();
    }

    public function findById($id)
    {
        return $this->order->where('id', $id)->first();
    }


    public function createOrderEvent($event, $status = true)
    {
        DB::beginTransaction();

        try {
            $status = $this->statusOfOrder(false);

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => 0.000,
                'subtotal' => $event['price'],
                'total' => $event['price'],
                'user_id' => auth()->id(),
                'order_status_id' => $status->id,
            ]);


            $this->orderEvent($order, $event);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create($request, $status = 3)
    {

        try {
            DB::beginTransaction();

            $data = $this->calculateTheOrder($request);
            $status = $this->statusOfOrder(3);

            if (!$data) {
                return false;
            }

            if(session()->has('discount')){
                $coupon_data = (new CouponController)->getCouponData(session()->get('discount'),$data['total']);
            }else{
                $coupon_data = null;
            }

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => $coupon_data && $coupon_data[0] ? $coupon_data[1]['coupon_value'] : 0.000,
                'total' => $coupon_data && $coupon_data[0] ? $coupon_data[1]['total'] : $data['total'],
                'subtotal' => $data['subtotal'],
                'user_id' => $request->user_id,
                'order_status_id' => $status->id,
            ]);

            if($coupon_data){
                $order->coupon()->create([
                    'coupon_id' => $coupon_data[2]['id'],
                    'code' => $coupon_data[2]['code'],
                    'discount_type' => $coupon_data[2]['discount_type'],
                    'discount_percentage' => $coupon_data[2]['discount_percentage'],
                    'discount_value' => $coupon_data[2]['discount_value'],
                ]);
            }

            if($request['name'] && $request['name'] != ''){
                $order->user->update(['name'=> $request['name']]);
            }
            $this->orderItems($order, $request);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function orderItems($order, $request)
    {
        $order->orderItems()->create([
            'package_id'    => $request->package_id,
            'duration_type'    => $request->duration_type,
            'total'        => $order->subtotal,
            'start_date'   => date('Y-m-d H:i:s'),
            'user_id'      => $request->user_id,
            'expired_date' => date('Y-m-d',strtotime('+'.($request->duration_type == 1 ? 1 : 12).' months',strtotime(  date('Y-m-d ')) )),
        ]);
    }

    public function orderEvent($order, $event)
    {

    }

    public function update($request, $boolean)
    {
        $order = $this->findById($request['OrderID']);

        $status = $this->statusOfOrder($boolean);

        $order->update([
            'is_hold' => false,
            'order_status_id' => $status['id']
        ]);

        if($boolean){
            //createChannel
            $request->merge([
                'name' => $order->user->name . " Channel",
                'package_id'  => $order->orderItems[0]->package_id,
                'id_users'  => $order->user_id,
                'days'      => $order->orderItems[0]->duration_type == 2 ? 365 : 1,
            ]);

            $this->channel->create($request);
        }
        return $order;
    }

    public function statusOfOrder($type)
    {
        if ($type == 1) {
            $status = $this->status->successPayment()->first();
        }else if($type == 2){
            $status = $this->status->failedOrderStatus()->first();
        }else if ($type == 3) {
            $status = $this->status->pendingOrderStatus()->first();
        }
        return $status;
    }




    private function notify(OrderItem $orderItem): void
    {
        // $orderCourse->user->notify(new NewCourseEnrollmentNotification($orderItem->offer));
    }
}
