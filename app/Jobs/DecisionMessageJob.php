<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Channel\Services\WAService;
use Modules\Message\Entities\DecisionMessage;

class DecisionMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $decision_message;

    public function __construct(DecisionMessage $decision_message)
    {
        $this->decision_message = $decision_message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $messageObj = $this->decision_message;
        $msgData = [
            'phone'  => $messageObj->whatsapp ,
        ];

        if(!$messageObj->is_sent){
            if($messageObj->message_data->all()['message_type'] == 'image'){
//                $msgData['url']    = $messageObj->message_data->all()['url'];
//                $msgData['caption']    = $messageObj->message_data->all()['body'];
//                $result = (new WAService())->sendImage($messageObj->channel_id, $msgData);
                $msgData['body']    = $messageObj->message_data->all()['body'];
                $result1 = (new WAService())->sendMessage($messageObj->channel_id, $msgData);

                $pdfData['phone'] = $msgData['phone'];
                $pdf = $messageObj->message_data->all()['url'];
                if(is_array($pdf)){
                    foreach ($pdf as $one){
                        $pdfData['url'] = $one;
                        $result = (new WAService())->sendFile($messageObj->channel_id, $pdfData);
                    }
                }else{
                    $pdfData['url'] = $messageObj->message_data->all()['url'];
                    $result = (new WAService())->sendFile($messageObj->channel_id, $pdfData);
                }

                logger((array) $result);
            }else{
                $msgData['body']    = $messageObj->message_data->all()['body'];
                $result = (new WAService())->sendMessage($messageObj->channel_id, $msgData);
            }
            $result = json_decode(json_encode($result), true);
            $queue_data = $messageObj->queue_data->all() ?? [];
            $queue_data['message_id'] = ($result['data']['key']['fromMe'] ? 'true' : 'false').'_'.str_replace('@s.whatsapp.net','@c.us',$result['data']['key']['remoteJid']).'_' .$result['data']['key']['id'];

            $messageObj->update([
                'is_sent'=>1,
                'queue_data' => $queue_data,
            ]);
        }
    }
}
