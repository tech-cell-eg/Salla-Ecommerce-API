<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    public function definition(): array
    {
        static $tagNames = [
            'electronics', 'fashion', 'home', 'sports', 'outdoor', 'beauty', 'tech', 'gaming',
            'fitness', 'travel', 'kitchen', 'books', 'music', 'health', 'toys', 'jewelry',
            'pets', 'garden', 'office', 'automotive', 'baby', 'crafts', 'food', 'luxury',
            'vintage', 'eco-friendly', 'trending', 'seasonal', 'sale', 'new-arrival',
        ];

        $name = $this->faker->randomElement($tagNames);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}