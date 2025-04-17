<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feature>
 */
class FeatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(8),
            'icon' => $this->faker->optional(0.8)->randomElement([
                'fas fa-shipping-fast',
                'fas fa-headset',
                'fas fa-lock',
                'fas fa-gift',
                'fas fa-sync-alt',
            ]), // 80% chance of having an icon
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}