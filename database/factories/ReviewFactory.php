<?php
namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected static $arabicComments = [
        'منتج رائع وجيد جداً ينصح به',
        'الشحن سريع والمنتج ممتاز',
        'جودة عالية وسعر مناسب',
        'المنتج جيد ولكن الشحن تأخر قليلاً',
        'لا ينصح به، به بعض العيوب',
        'أفضل منتج اشتريته هذا العام',
        'جيد ولكن السعر مرتفع قليلاً',
        'المنتج ممتاز والخدمة جيدة',
        'الشاشة ممتازة ولكن البطارية لا تدوم طويلاً',
        'الكاميرا رائعة ولكن التطبيقات تستهلك الكثير من الذاكرة'
    ];

    public function definition(): array
    {
        return [
            'product_id' => null,
            'user_id' => User::all()->random()->id,
            'comment' => $this->faker->optional(0.9)->randomElement(static::$arabicComments),
            'rate' => $this->faker->randomElement(['1', '2', '3', '4', '5']),
            'status' => $this->faker->boolean(80),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }
}