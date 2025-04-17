<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductTag>
 */
class ProductTagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tag_id' => Tag::all()->random()->id,
            'product_id' => Product::all()->random()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}