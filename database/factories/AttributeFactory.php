<?php
namespace Database\Factories;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    protected static $arabicAttributes = [
        'اللون',
        'السعة',
        'الذاكرة',
        'مقاس الشاشة',
        'سعة البطارية',
        'المادة',
        'المعالج',
        'نظام التشغيل'
    ];

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(static::$arabicAttributes);
        return [
            'name' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($attribute) {
            $values = [];
            
            // Generate appropriate values based on attribute type
            switch($attribute->name) {
                case 'اللون':
                    $values = ['أسود', 'أبيض', 'فضي', 'أزرق', 'ذهبي'];
                    break;
                case 'السعة':
                    $values = ['32 جيجابايت', '64 جيجابايت', '128 جيجابايت', '256 جيجابايت'];
                    break;
                case 'الذاكرة':
                    $values = ['4 جيجابايت', '8 جيجابايت', '16 جيجابايت'];
                    break;
                case 'مقاس الشاشة':
                    $values = ['5.5 بوصة', '6.1 بوصة', '6.7 بوصة', '15.6 بوصة'];
                    break;
                case 'سعة البطارية':
                    $values = ['3000 مللي أمبير', '4000 مللي أمبير', '5000 مللي أمبير'];
                    break;
                case 'المادة':
                    $values = ['بلاستيك', 'معدني', 'زجاج'];
                    break;
                default:
                    $values = ['أساسي', 'متوسط', 'متقدم'];
            }
            
            foreach ($values as $value) {
                AttributeValue::factory()->create([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
        });
    }
}