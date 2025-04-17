<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['product', 'category', 'all']);
        $productId = $type === 'product' ? Product::factory()->create()->id : null;
        $categoryId = $type === 'category' ? Category::factory()->create()->id : null;
        $discountPercentage = $type === 'all' ? $this->faker->numberBetween(5, 50) : null;

        return [
            'code' => $this->faker->unique()->bothify('COUPON-####-??'),
            'type' => $type,
            'product_id' => $productId,
            'category_id' => $categoryId,
            'discount_precentage' => $discountPercentage,
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'limit_number' => $this->faker->optional(0.7)->numberBetween(10, 100), // 70% chance of having a limit
            'time_used' => $this->faker->numberBetween(0, 20),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}