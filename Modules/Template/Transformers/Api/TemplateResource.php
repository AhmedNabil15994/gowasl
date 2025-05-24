<?php

namespace Modules\Template\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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
            'title'=> $this->title,
            'description'=> $this->description,
        ];
    }
}
