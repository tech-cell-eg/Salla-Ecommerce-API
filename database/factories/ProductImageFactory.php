<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'image' => $this->faker->imageUrl(800, 600, 'products'),
            'product_id' => null, 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}