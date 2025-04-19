<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name"=>$this->user_name,
            "email"=>$this->user_email,
            "phone"=>$this->user_phone,
            "country"=>$this->country,
            "governorate"=>$this->governorate,
            "city"=>$this->city,
            "street"=>$this->street,
            "note"=>$this->note,
            "orderItems"=>OrderItemResource::collection($this->items)

        ];
    }
}
