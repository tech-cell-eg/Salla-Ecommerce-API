<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "prodcut_id"=>$this->product_id,
            "product_name"=>$this->product_name,
            "product_desc"=>$this->product_desc,
            "product_quantity"=>$this->product_quantity,
            "product_price"=>$this->product_price
        ];
    }
}
