<?php

namespace Modules\Addon\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class AddonResource extends JsonResource
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
            'title' => $this->title,
            'description'=> $this->description,
            'monthly_price'=> number_format($this->monthly_price,3),
            'annual_price'=> number_format($this->annual_price,3),
            'order'=> $this->order,
            'module'=> $this->module,
            'image' => $this->getFirstMediaUrl('images'),
            'status' => $this->status ? trans('addon::dashboard.active') : trans('addon::dashboard.inactive'),
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
