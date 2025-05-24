<?php

namespace Modules\Message\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Channel\Entities\Channel;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Message\Http\Requests\Dashboard\BulkMessageRequest;

class BulkMessageController extends Controller
{
    use CrudDashboardController{
        CrudDashboardController::__construct as CrudeConstruct;
    }

    public function __construct()
    {
        $this->CrudeConstruct();
        $this->setViewPath('message::dashboard.bulk_messages');
    }

    public function store(BulkMessageRequest $request) {
        $bulkMessageObj = $this->repository->createBulkMessage($request);
        if ($bulkMessageObj) {
            return Response()->json([
                'success' => true,
                'message' => __('apps::dashboard.messages.created'),
                'id' => $bulkMessageObj->id
            ]);
        }

        return Response()->json([
            'success' => false,
            'message' => __('channel::dashboard.channels.exceed_daily_limit')
        ],401);
    }

}
