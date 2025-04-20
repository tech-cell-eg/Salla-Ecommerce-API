<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDetailFactory extends Factory
{
    protected static $arabicKeys = [
        'اللون',
        'المقاس',
        'الوزن',
        'المعالج',
        'الذاكرة',
        'التخزين',
        'الشاشة',
        'البطارية',
        'نظام التشغيل',
        'الكاميرا',
        'الشحن',
        'الضمان'
    ];

    protected static $arabicValues = [
        'أسود', 'أبيض', 'فضي', 'أزرق', 'ذهبي', 'وردي',
        '15.6 بوصة', '6.7 بوصة', '1.4 بوصة', '27 بوصة',
        '8 نواة', '4 نواة', 'معالج M1', 'سناب دراجون 888',
        '8 جيجابايت', '16 جيجابايت', '32 جيجابايت',
        '256 جيجابايت', '512 جيجابايت', '1 تيرابايت',
        '5000 مللي أمبير', '4000 مللي أمبير', 'بطارية يومين',
        'أندرويد', 'iOS', 'ويندوز 11', 'ماك أو إس',
        '48 ميجابيكسل', '12 ميجابيكسل', 'ثلاثية الكاميرات',
        'شحن سريع 65 واط', 'شحن لاسلكي', 'شحن عكسي',
        'سنتان', 'عام واحد', '5 سنوات'
    ];

    public function definition(): array
    {
        return [
            'key' => $this->faker->randomElement(static::$arabicKeys),
            'value' => $this->faker->randomElement(static::$arabicValues),
            'product_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}