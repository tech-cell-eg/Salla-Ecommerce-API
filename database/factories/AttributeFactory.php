<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Color',
                'Size',
                'Material',
                'Weight',
                'Storage',
                'Screen Size',
                'Battery',
                'Style',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($attribute) {
            AttributeValue::factory()->count(3)->create([
                'attribute_id' => $attribute->id,
            ]);
        });
    }
}