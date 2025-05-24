<?php

namespace Modules\Channel\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'number'         => $this->number,
            'days'        => $this->days,
            'owner'         => $this->owner->name,
            'valid_until'    => date('d-m-Y' , strtotime($this->valid_until)),
            'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
        ];
    }
}
