<?php

namespace Modules\Apps\Http\Controllers\Vendor;

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
        $channelsData = auth()->user()->channels()->withCount(['contacts','messages','bots','templates'])->get();

        $data = [
            'channels'  => auth()->user()->channels()->count(),
            'contacts'  => $channelsData->sum('contacts_count'),
            'messages'  => $channelsData->sum('messages_count'),
            'bots'      => $channelsData->sum('bots_count'),
            'templates' => $channelsData->sum('templates_count'),
        ];

        return view('apps::vendor.index',compact('data'));
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
