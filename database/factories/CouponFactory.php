<?php
namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected static $arabicCouponTypes = [
        'خصم على منتج',
        'خصم على فئة',
        'خصم عام'
    ];

    public function definition(): array
    {
        $type = $this->faker->randomElement(['product', 'category', 'all']);
        $productId = $type === 'product' ? Product::factory()->create()->id : null;
        $categoryId = $type === 'category' ? Category::factory()->create()->id : null;
        $discountPercentage = $type === 'all' ? $this->faker->numberBetween(5, 30) : null;

        return [
            'code' => 'خصم-' . $this->faker->unique()->bothify('####'),
            'type' => $type,
            'product_id' => $productId,
            'category_id' => $categoryId,
            'discount_precentage' => $discountPercentage ?? $this->faker->numberBetween(10, 50),
            'start_date' => $this->faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 months')->format('Y-m-d'),
            'limit_number' => $this->faker->optional(0.7)->numberBetween(20, 100),
            'time_used' => $this->faker->numberBetween(0, 50),
            'is_active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}