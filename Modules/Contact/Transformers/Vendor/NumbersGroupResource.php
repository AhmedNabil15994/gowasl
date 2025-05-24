<?php

namespace Modules\Contact\Transformers\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;

class NumbersGroupResource extends JsonResource
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
            'title'=> $this->title,
            'description'=> $this->description,
            'status' => $this->status ,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
