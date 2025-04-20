<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    protected static $arabicFeatures = [
        'شحن سريع',
        'دعم فني',
        'دفع آمن',
        'عروض خاصة',
        'إرجاع سهل'
    ];

    protected static $arabicDescriptions = [
        'شحن سريع خلال 24-48 ساعة لجميع أنحاء المملكة',
        'دعم فني متاح على مدار الساعة طوال أيام الأسبوع',
        'أنظمة دفع آمنة ومشفرة لحماية معلوماتك',
        'عروض وتخفيضات حصرية لأعضاء المتجر',
        'سياسة إرجاع ميسرة خلال 14 يوم من الشراء'
    ];

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(static::$arabicFeatures);
        return [
            'name' => $name,
            'description' => $this->faker->randomElement(static::$arabicDescriptions),
            'icon' => $this->faker->optional(0.8)->randomElement([
                'fas fa-shipping-fast',
                'fas fa-headset',
                'fas fa-lock',
                'fas fa-gift',
                'fas fa-sync-alt',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}