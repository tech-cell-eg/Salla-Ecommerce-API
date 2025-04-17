<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeValue>
 */
class AttributeValueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'attribute_id' => null,
            'value' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}