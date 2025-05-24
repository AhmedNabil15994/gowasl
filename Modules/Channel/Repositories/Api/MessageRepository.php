<?php

namespace Modules\Channel\Repositories\Api;

use App\Jobs\DecisionMessageJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Channel\Entities\Channel;
use Modules\Channel\Services\WAService;
use Modules\Message\Entities\DecisionMessage;

class MessageRepository
{
    public function __construct(DecisionMessage $decisionMessage)
    {
        $this->decisionMessage = $decisionMessage;
    }

    public function createDecisionMessage($request) {
        $message_data = $request['message_data'];
        $on = Carbon::parse($request['send_at']);
        $decision_message = [
            'channel_id' => CHANNEL_ID,
            'send_at'  => date('Y-m-d H:i:s',strtotime($on)),
            'is_replied' => 0,
            'whatsapp'     => $request['phone'],
            'message_data'  => $message_data,
            'status'        => 1,
            'job_queue_id'  => (string) \Str::uuid(),
        ];

        $deviceObj = Channel::getOneByChannelId(CHANNEL_ID);
//        $check = $deviceObj->incrementDialyUsage(1);
//        if(!$check){
//            return false;
//        }

        DB::beginTransaction();
        try {

            DB::commit();

            $model = $this->decisionMessage->create($decision_message);
            $job = (new DecisionMessageJob($model))->delay($on);
            $jobID = custom_dispatch($job);

            $model->update([
                'queue_data' => ['job'   => $jobID,],
            ]);

            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
