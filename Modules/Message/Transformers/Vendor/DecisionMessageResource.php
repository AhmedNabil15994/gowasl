<?php

namespace Modules\Message\Transformers\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;

class DecisionMessageResource extends JsonResource
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
            'message_data' => $this->message_data,
            'send_at' => $this->send_at ,
            'is_replied' => $this->is_replied ,
            'whatsapp' => $this->whatsapp ,
            'queue_data' => $this->queue_data ,
            'is_sent'   => $this->is_sent,
            'progress' => $this?->job?->queue ? __('message::dashboard.bulk_messages.datatable.in_progress') : __('message::dashboard.bulk_messages.datatable.done') ,
            'status' => $this->status ,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
