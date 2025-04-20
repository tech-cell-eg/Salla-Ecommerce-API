<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    protected static $arabicTitles = [
        'عروض خاصة على الأجهزة الذكية',
        'خصومات تصل إلى 30% على الحواسيب',
        'أحدث الهواتف الذكية بأسعار مميزة',
        'ملحقات الحاسوب بأسعار تنافسية',
        'عروض الساعات الذكية لفترة محدودة'
    ];

    protected static $arabicDescriptions = [
        'احصل على أفضل الأجهزة بأسعار لا تقارن',
        'خصومات كبيرة على مجموعة واسعة من المنتجات',
        'أحدث الموديلات متوفرة الآن في متجرنا',
        'جودة عالية بأسعار تنافسية',
        'تسوق الآن ووفر مع عروضنا الحصرية'
    ];

    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(static::$arabicTitles),
            'description' => $this->faker->randomElement(static::$arabicDescriptions),
            'button_text' => 'تسوق الآن',
            'button_url' => '/products',
            'image' => $this->faker->imageUrl(1920, 600, 'electronics'),
            'status' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}