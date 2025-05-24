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
use Modules\Message\Entities\BulkMessage;

class BulkMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $bulk_message;

    public function __construct(BulkMessage $bulk_message)
    {
        $this->bulk_message = $bulk_message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $messageObj = $this->bulk_message;
        $messageData = $messageObj->message_data->all();
        $vars = ['{CUSTOMER_NAME}','{CUSTOMER_PHONE}','{MESSAGE_TIMESTAMPS}'];

        $hasVars = 0;
        foreach ($messageData as $item) {
            foreach ($vars as $var){
                if (strpos($item, $var) !== FALSE) {
                    $hasVars = 1;
                }
            }
        }

        $type = '';
        if($messageObj->message_type == 'text'){
            $type = 1;
        }else if($messageObj->message_type == 'image'){
            $type = 2;
        }else if($messageObj->message_type == 'video'){
            $type = 3;
        }else if($messageObj->message_type == 'audio'){
            $type = 4;
        }else if($messageObj->message_type == 'file'){
            $type = 5;
        }else if($messageObj->message_type == 'link'){
            $type = 16;
            $messageData['body'] = $messageData?->description ?? $messageData?->title;
        }else if($messageObj->message_type == 'sticker'){
            $type = 6;
        }else if($messageObj->message_type == 'gif'){
            $type = 7;
        }else if($messageObj->message_type == 'location'){
            $type = 8;
        }else if($messageObj->message_type == 'contact'){
            $type = 9;
        }else if($messageObj->message_type == 'Mention'){
            $type = 11;
        }

        $newMessageData = [];
        $phones = [];
        if($hasVars){
            $contacts = $messageObj->contacts()->groupBy('whatsapp')->get();
            $i = 0;
            foreach ($contacts as $key => $contact){
                foreach ($messageData as $itemKey => $item) {
                    $item = str_replace('{CUSTOMER_NAME}',$contact->name,$item);
                    $item = str_replace('{CUSTOMER_PHONE}',$contact->whatsapp,$item);
                    $item = str_replace('{MESSAGE_TIMESTAMPS}',Carbon::now()->addSeconds(($i*$messageObj->interval) + 5),$item);
                    $newMessageData[$key][$itemKey] = $item;
                    $phones[] = $contact->whatsapp;
                }
                $i++;
            }
        }else{
            $newMessageData = $messageData;
            $phones = $messageObj->bulk_contacts->phones;
        }

        $msgData = [
            'interval'  => $messageObj->interval >= 60 ? $messageObj->interval : 60 ,
            'phones'    => $phones,
            'messageType'   => $type,
            'messageData'   => $newMessageData,
        ];

        return (new WAService())->sendBulkMessage($messageObj->channel->channel_id, $msgData);
    }
}
