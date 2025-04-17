<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VariantAttribute>
 */
class VariantAttributeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_variant_id' => ProductVariant::factory()->create()->id,
            'attribute_value_id' => AttributeValue::factory()->create()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}