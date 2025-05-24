<?php

namespace Modules\Cart\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use IlluminateAgnostic\Collection\Support\Carbon;

class CartResource extends JsonResource
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
            'id' => $this['id'],
            'name' => $this['name'],
            'price' => number_format($this['price'],3),
            'attributes' => [
                'item_id' => $this['attributes']['item_id'],
                'type' => $this['attributes']['type'],
                'image' => $this['attributes']['image'],
                'sub_title' => $this['attributes']['product']['sub_title'],
                'category' => $this['attributes']['product']['category'],
            ],
        ];
    }
}
