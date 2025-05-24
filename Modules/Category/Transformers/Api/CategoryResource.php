<?php

namespace Modules\Category\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $response = [
           'id'            => $this->id,
           'image'         => $this->getFirstMediaUrl('images'),
           'title'         => $this->title,
       ];

       if(is_null($this->category_id)){

            $response['children'] = CategoryResource::collection($this->children()->active()->get());
       }

        return $response;
    }
}
