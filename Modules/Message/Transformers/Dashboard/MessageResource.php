<?php

namespace Modules\Message\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message_id' => $this->message_id,
            'channel_id'=> $this->channel_id,
            'channel' => $this->channel?->name,
            'body' => $this->body ,
            'author' => $this->author == 'Me' ? __('message::dashboard.messages.datatable.me') : $this->author ,
            'fromMe' => $this->fromMe ,
            'chatName' => $this->chatName ,
            'pushName' => $this->pushName ,
            'remoteJid' => $this->remoteJid ,
            'messageType' => $this->messageType ,
            'deviceSentFrom' => $this->deviceSentFrom ,
            'timeFormatted' => $this->timeFormatted,
            'time' => $this->time,
            'status' => $this->status ,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
