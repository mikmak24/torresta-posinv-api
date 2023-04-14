<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'product_code'          => $this->product_code,
            'product_name'          => $this->product_name,
            'product_description'   => $this->product_description,
            'product_price'         => $this->product_price,
            'product_quantity'      => $this->product_quantity,
            'product_status'        => $this->product_status,
            'product_image'         => $this->product_image,
            'category_id'           => $this->category_id
        ];
    }
}
