<?php

namespace Modules\Package\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'daily_limit'=> $this->daily_limit,
            'image' => $this->getFirstMediaUrl('images'),
        ];
    }
}
