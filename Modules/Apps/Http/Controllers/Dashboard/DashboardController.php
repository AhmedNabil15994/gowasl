<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Addon\Entities\Addon;
use Modules\Authorization\Entities\Role;
use Modules\Bot\Entities\Bot;
use Modules\Channel\Entities\Channel;
use Modules\Contact\Entities\Contact;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Exam\Entities\Exam;
use Modules\Message\Entities\Message;
use Modules\Order\Entities\Order;
use Modules\Package\Entities\Package;
use Modules\Template\Entities\Template;
use Modules\Trainer\Entities\Trainer;
use Modules\User\Entities\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'packages' => Package::active()->count(),
            'addons'    => Addon::active()->count(),
            'orders'    => Order::count(),
            'channels'  => Channel::count(),
            'contacts'  => Contact::active()->count(),
            'messages'  => Message::count(),
            'bots'      => Bot::active()->count(),
            'templates' => Template::active()->count(),
            'users'     => User::whereHas('roles.permissions',function ($q){
                                $q->where('name','seller_access');
                            })->count(),
            'active_orders' => Order::successPay()->count(),
            'pending_orders' => Order::pending()->count(),

        ];
        return view('apps::dashboard.index',compact('data'));
    }
    private function filter($request, $model)
    {

        return $model->where(function ($query) use ($request) {

            // Search Users by Created Dates
            if ($request->from)
                $query->whereDate('created_at', '>=', $request->from);

            if ($request->to)
                $query->whereDate('created_at', '<=', $request->to);

        });
    }
}
