<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductDetail>
 */
class ProductDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'key' => $this->faker->word,
            'value' => $this->faker->sentence(2),
            'product_id' => null, 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}