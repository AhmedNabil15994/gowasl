<?php

namespace Modules\Bot\Transformers\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;

class BotResource extends JsonResource
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
            'channel_id'=> $this->channel_id,
            'channel' => $this->channel?->name,
            'message_type'=> $this->message_type == 'same' ? __('bot::dashboard.bots.message_types.type_1') :  __('bot::dashboard.bots.message_types.type_2'),
            'message'=> $this->message,
            'reply_type'=> $this->reply_type,
            'reply'=> $this->reply,
            'order'=> $this->order,
            'status' => $this->status ,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
