<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => null,
            'user_id' => User::all()->random()->id,
            'comment' => $this->faker->optional(0.9)->paragraph(2), // 90% chance of having a comment
            'rate' => $this->faker->randomElement(['1', '2', '3', '4', '5']),
            'status' => $this->faker->boolean(80), // 80% chance of being active
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}