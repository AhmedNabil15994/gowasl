<?php

namespace Modules\Message\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Channel\Entities\Channel;
use Modules\Contact\Entities\Contact;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Message\Http\Requests\Dashboard\BulkMessageRequest;
use Modules\Message\Http\Requests\Dashboard\DecisionMessageRequest;

class DecisionMessageController extends Controller
{
    use CrudDashboardController{
        CrudDashboardController::__construct as CrudeConstruct;
    }
    public function __construct()
    {
        $this->CrudeConstruct();
        $this->setViewPath('message::dashboard.decision_messages');
    }

    public function store(DecisionMessageRequest $request) {
        $messageObj = $this->repository->createDecisionMessage($request);
        if ($messageObj) {
            return Response()->json([
                'success' => true,
                'message' => __('apps::dashboard.messages.created'),
                'id' => $messageObj->id
            ]);
        }

        return Response()->json([
            'success' => false,
            'message' => __('channel::dashboard.channels.exceed_daily_limit')
        ],401);
    }
}
