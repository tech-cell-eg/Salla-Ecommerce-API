<?php
namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeValueFactory extends Factory
{
    protected static $arabicValues = [
        'أسود', 'أبيض', 'فضي', 'أزرق', 'ذهبي', 'أحمر',
        '32 جيجابايت', '64 جيجابايت', '128 جيجابايت', '256 جيجابايت', '512 جيجابايت',
        '4 جيجابايت', '8 جيجابايت', '16 جيجابايت', '32 جيجابايت',
        '5.5 بوصة', '6.1 بوصة', '6.7 بوصة', '15.6 بوصة', '17 بوصة',
        '3000 مللي أمبير', '4000 مللي أمبير', '5000 مللي أمبير', '6000 مللي أمبير',
        'بلاستيك', 'معدني', 'زجاج', 'جلد'
    ];

    public function definition(): array
    {
        return [
            'attribute_id' => null,
            'value' => $this->faker->unique()->randomElement(static::$arabicValues),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}