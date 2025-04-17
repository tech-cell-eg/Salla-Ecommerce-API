<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductDetail;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(3);
        $hasVariants = $this->faker->boolean(30); // 30% chance of having variants
        $hasDiscount = $this->faker->boolean(20); // 20% chance of having a discount
        $manageStock = $this->faker->boolean(50); // 50% chance of managing stock

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'small_desc' => $this->faker->sentence(10),
            'description' => $this->faker->paragraph(3),
            'status' => $this->faker->boolean(80), // 80% chance of active
            'sku' => $this->faker->unique()->bothify('SKU-####-??'),
            'has_variants' => $hasVariants,
            'price' => $hasVariants ? null : $this->faker->randomFloat(3, 10, 1000),
            'has_discount' => $hasDiscount,
            'discount' => $hasDiscount ? $this->faker->randomFloat(2, 5, 50) : null,
            'start_discount' => $hasDiscount ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'end_discount' => $hasDiscount ? $this->faker->dateTimeBetween('now', '+1 month') : null,
            'manage_stock' => $manageStock,
            'quantity' => $manageStock ? $this->faker->numberBetween(0, 100) : null,
            'purchased' => $this->faker->numberBetween(0, 50),
            'available_in_stock' => $this->faker->boolean(90), // 90% chance of being in stock
            'category_id' => Category::factory()->create()->id,
            'brand_id' => Brand::factory()->create()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($product) {
            ProductImage::factory()->count(4)->create([
                'product_id' => $product->id,
            ]);
            ProductDetail::factory()->count(3)->create([
                'product_id' => $product->id,
            ]);
            $tags = Tag::inRandomOrder()->take($this->faker->numberBetween(2, 5))->get();
            $product->tags()->attach($tags->pluck('id'));
            Review::factory()->count($this->faker->numberBetween(1, 3))->create([
                'product_id' => $product->id,
                'user_id' => User::factory()->create()->id,
            ]);
            if ($product->has_variants) {
                $variants = ProductVariant::factory()->count($this->faker->numberBetween(1, 3))->create([
                    'product_id' => $product->id,
                    'is_default' => fn($index) => $index === 0, // First variant is default
                ]);
                foreach ($variants as $variant) {
                    $attributeValues = AttributeValue::factory()->count($this->faker->numberBetween(1, 3))->create([
                        'attribute_id' => Attribute::inRandomOrder()->first()->id,
                    ]);
                    $variant->attributeValues()->attach($attributeValues->pluck('id'));
                }
            }
        });
    }
}
