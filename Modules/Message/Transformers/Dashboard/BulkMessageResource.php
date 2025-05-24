<?php

namespace Modules\Message\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BulkMessageResource extends JsonResource
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
            'message_type' => $this->message_type ,
            'message_data' => $this->message_data,
            'sending_date' => $this->sending_date ,
            'bulk_flag' => $this->bulk_flag ,
            'bulk_contacts' => $this->bulk_contacts ,
            'contacts_count'    => count($this->bulk_contacts->phones),
            'queue_data' => $this->queue_data ,
            'progress' => $this?->job?->queue ? __('message::dashboard.bulk_messages.datatable.in_progress') : __('message::dashboard.bulk_messages.datatable.done') ,
            'status' => $this->status ,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
