<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id2' => $this->id,
            'name' => $this->name,

            'description' => $this->description,
            'price' => $this->price,
            'remaining_quantity' => $this->remaining_quantity,
            'purchased' => $this->purchased,
            'small_desc' => $this->small_desc,
            'sku' => $this->sku,
            'reviews_count' => $this->reviews_count,
            'reviews_average' => $this->reviews_average,
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'has_variants' => $this->has_variants,
            'has_discount' => $this->has_discount,
            'discount' => $this->discount,
            'start_discount' => $this->start_discount,
            'end_discount' => $this->end_discount,
            'manage_stock' => $this->manage_stock,
            'available_in_stock' => $this->available_in_stock,
            'status' => $this->status,
          
            'category' => new CategoryResource($this->whenLoaded('category')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
           
           
        ];
    }
}
