<?php
namespace App\Handler;
use Modules\Bot\Entities\Bot;
use Modules\Channel\Services\WAService;
use Modules\Contact\Entities\Contact;
use Modules\Message\Entities\DecisionMessage;
use Modules\Message\Entities\Message;
use \Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Illuminate\Support\Facades\Http;
use Spatie\WebhookServer\WebhookCall;

class MessagesWebhook extends ProcessWebhookJob{

	public function handle(){
	    $data = json_decode($this->webhookCall, true);
	    $mainData = $data['payload'];
        Logger($mainData);
	    if(isset($mainData['conversation']) && isset($mainData['conversation']['lastMessage']) && $mainData['conversation']['lastMessage']){
	    	 return $this->incomingMessage($mainData);
	    }

   		return 1;
	}

	public function incomingMessage($mainData){
		$convData = $mainData['conversation'];
	   	$sessionId = $mainData['sessionId'];
	   	$msg = $convData['lastMessage'];
        $msg['message_id'] = $msg['fromMe'].'_'.str_replace('@s.whatsapp.net','@c.us',$msg['remoteJid']).'_' .$msg['id'];

        $sentMsg = $msg;
        if($msg['fromMe'] == 'false'){
            $botObj = Bot::findBotMessage($msg['body'],$mainData['sessionId']);
            $botObj?->channel->incrementDialyUsage();

            //Send Message Here
            if($botObj){
                $msgData = $this->formatMessage($msg,$botObj,$sessionId);
            }

            if(in_array($msg['body'],[1,2])){
                $lastChatMessage = Message::getUserDecisionMessage($sessionId,$msg['chatName']);
                if($lastChatMessage){
                    $data = (array) $lastChatMessage->decision_message?->message_data?->all() ?? [];
                    $queue_data = (array) $lastChatMessage->decision_message?->queue_data?->all() ?? [];
                    $key = $msg['body'] == 1 ? "agree" : "refuse" ;
                    $replyData['phone'] = $msg['chatName'];

                    $messageId = '';
                    $this->notifyUserAction($key,$msg['chatName'],$lastChatMessage->decision_message,$sessionId);
                    if($key == 'agree' && isset($data[$key]['invitations']) && $data[$key]['invitations'] > 1){
                        $result = $this->sendDecisionActionMessage($data[$key],$replyData,$sessionId,$data[$key]['invitations'],$msg['chatName']);
                    }else{
                        $result = $this->sendDecisionActionMessage($data[$key],$replyData,$sessionId);
                        $messageId = ($result['data']['key']['fromMe'] ? 'true' : 'false').'_'.str_replace('@s.whatsapp.net','@c.us',$result['data']['key']['remoteJid']).'_' .$result['data']['key']['id'];
                    }
                    $result = json_decode(json_encode($result), true);
                    Logger($result);
                    if(count($result)){
                        $queue_data['user_action'] = [
                            'message_id' => $messageId,
                            'action'    => $key,
                            'created_at'    => date('Y-m-d H:i:s'),
                        ];
                    }

                    $lastChatMessage->decision_message?->update([
                        'is_replied'=>1,
                        'queue_data'    => $queue_data,
                    ]);
                }
            }

        }

        $this->dealWithContacts($msg,$sessionId);

        unset($msg['id']);
        Message::firstOrCreate([
            'message_id'    => $msg['message_id'],
            'channel_id'    => $sessionId,
        ],$msg);

	   	return true;
	}

    public function dealWithContacts($msg,$sessionId)
    {
        Contact::firstOrCreate([
            'whatsapp' => $msg['chatName'],
            'channel_id'    => $sessionId,
        ],[
            'name'  => $msg['pushName'],
            'whatsapp' => $msg['chatName'],
            'channel_id'    => $sessionId,
            'mobile'    => $msg['chatName'],
        ]);
    }

    public function formatMessage($msg,$botObj,$sessionId)
    {
        $msgData['phone'] = explode('@',$msg['remoteJid'])[0];
        if($botObj?->reply_type == 'text'){
            $msgData['body'] = $this->dealWithVariables($msg,$botObj?->reply?->body);
            (new WAService())->sendMessage($sessionId, $msgData);
        }else if($botObj?->reply_type == 'image'){
            $msgData['url'] = $botObj?->reply?->url;
            $msgData['caption'] = $this->dealWithVariables($msg,$botObj?->reply?->caption);
            (new WAService())->sendImage($sessionId, $msgData);
        }else if($botObj?->reply_type == 'video'){
            $msgData['url'] = $botObj?->reply?->url;
            $msgData['caption'] = $this->dealWithVariables($msg,$botObj?->reply?->caption);
            (new WAService())->sendVideo($sessionId, $msgData);
        }else if($botObj?->reply_type == 'audio'){
            $msgData['url'] = $botObj?->reply?->url;
            (new WAService())->sendAudio($sessionId, $msgData);
        }else if($botObj?->reply_type == 'file'){
            $msgData['url'] = $botObj?->reply?->url;
            (new WAService())->sendFile($sessionId, $msgData);
        }else if($botObj?->reply_type == 'link'){
            $msgData['url'] = $botObj?->reply?->url;
            $msgData['title'] = $this->dealWithVariables($msg,$botObj?->reply?->title);
            $msgData['description'] = $this->dealWithVariables($msg,$botObj?->reply?->description);
            (new WAService())->sendLink($sessionId, $msgData);
        }else if($botObj?->reply_type == 'sticker'){
            $msgData['url'] = $botObj?->reply?->url;
            (new WAService())->sendSticker($sessionId, $msgData);
        }else if($botObj?->reply_type == 'gif'){
            $msgData['url'] = $botObj?->reply?->url;
            $msgData['caption'] = $this->dealWithVariables($msg,$botObj?->reply?->caption);
            (new WAService())->sendGif($sessionId, $msgData);
        }else if($botObj?->reply_type == 'location'){
            $msgData['lat'] = $botObj?->reply?->lat;
            $msgData['lng'] = $botObj?->reply?->lng;
            (new WAService())->sendLocation($sessionId, $msgData);
        }else if($botObj?->reply_type == 'contact'){
            $msgData['name'] = $botObj?->reply?->name;
            $msgData['contact'] = str_replace('+','',$botObj?->reply?->contact);
            $msgData['organization'] = $botObj?->reply?->name;
            (new WAService())->sendContact($sessionId, $msgData);
        }else if($botObj?->reply_type == 'mention'){
            $msgData['mention'] = str_replace('+','',$botObj?->reply?->mention);
            (new WAService())->sendMention($sessionId, $msgData);
        }
        return $msgData;
    }

    public function notifyUserAction($action,$phone,$decision_message,$sessionId)
    {
        $data = [
            'job_queue_id' => $decision_message->job_queue_id,
            'action'    => $action,
            'contact'   => $phone,
        ];

        WebhookCall::create()
            ->url($decision_message->message_data->notify_url)
            ->payload($data)
            ->doNotSign()
            ->dispatch();
    }

    public function sendDecisionActionMessage($action,$replyData,$sessionId,$count = 1,$phone=null)
    {
        $result = [];
        if($count > 1){
            $newMessageData = [];
            $phones = [];
            for ($i = 0; $i < $count; $i++) {
                $phones[] = $phone;
                $caption = $action['caption'];
                $caption.= " \r\n \r\n " .date('Y-m-d H:i:s',strtotime('+'.($i*30).' seconds'));
                $newMessageData[] = [
                    'url'   => $action['url'],
                    'caption'   => $caption,
                ];
            }
            $msgData = [
                'interval'  => 30 ,
                'phones'    => $phones,
                'messageType'   => 2,
                'messageData'   => $newMessageData,
            ];

            return (array) (new WAService())->sendBulkMessage($sessionId, $msgData);
        }
        if($action['message_type'] == 'text'){
            $replyData['body'] = $action['body'];
            if($action['body']){
                $result = (array) (new WAService())->sendMessage($sessionId, $replyData);
            }
        }else if($action['message_type'] == 'image'){
            $replyData['url'] = $action['url'];
            if($action['caption']){
                $replyData['caption'] = $action['caption'];
            }
            $result = (array) (new WAService())->sendImage($sessionId, $replyData);
        }else if($action['message_type'] == 'video'){
            $replyData['url'] = $action['url'];
            $replyData['caption'] = $action['caption'];
            $result = (array) (new WAService())->sendVideo($sessionId, $replyData);
        }else if($action['message_type'] == 'audio'){
            $replyData['url'] = $action['url'];
            $result = (array) (new WAService())->sendAudio($sessionId, $replyData);
        }else if($action['message_type'] == 'file'){
            $replyData['url'] = $action['url'];
            $result = (array) (new WAService())->sendFile($sessionId, $replyData);
        }else if($action['message_type'] == 'link'){
            $replyData['url'] = $action['url'];
            $replyData['title'] = $action['title'];
            $replyData['description'] = $action['description'];
            $result = (array)  (new WAService())->sendLink($sessionId, $replyData);
        }else if($action['message_type'] == 'sticker'){
            $replyData['url'] = $action['url'];
            $result = (array) (new WAService())->sendSticker($sessionId, $replyData);
        }else if($action['message_type'] == 'gif'){
            $replyData['url'] = $action['url'];
            $replyData['caption'] = $action['caption'];
            $result = (array) (new WAService())->sendGif($sessionId, $replyData);
        }else if($action['message_type'] == 'location'){
            $replyData['lat'] = $action['lat'];
            $replyData['lng'] = $action['lng'];
            $result = (array) (new WAService())->sendLocation($sessionId, $replyData);
        }else if($action['message_type'] == 'contact'){
            $replyData['name'] = $action['name'];
            $replyData['contact'] = $action['contact'];
            $replyData['organization'] = $action['name'];
            $result = (array)  (new WAService())->sendContact($sessionId, $replyData);
        }else if($action['message_type'] == 'mention'){
            $replyData['mention'] = str_replace('+','',$action['mention']);
            $result = (array)  (new WAService())->sendMention($sessionId, $replyData);
        }
        return (array) $result;
    }
    public function dealWithVariables($msg,$text) {
        $text = str_replace('{CUSTOMER_NAME}',$msg['pushName'],$text);
        $text = str_replace('{CUSTOMER_PHONE}',$msg['author'],$text);
        $text = str_replace('{MESSAGE_TIMESTAMPS}',$msg['timeFormatted'],$text);
        return $text;
    }
}
