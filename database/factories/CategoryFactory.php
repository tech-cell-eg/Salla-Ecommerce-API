<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word;
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'status' => $this->faker->boolean(80), // 80% chance of true
            'parent' => null, 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}