<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected static $arabicCategories = [
        'حواسيب محمولة',
        'هواتف ذكية',
        'ساعات ذكية',
        'أجهزة لوحية',
        'ملحقات الحاسوب',
        'شاشات',
        'طابعات',
        'سماعات',
        'أجهزة تخزين',
        'شبكات',
        'حواسيب مكتبية',
        'سماعات أجهزة',
        'أجهزة شبكات',
        'كاميرات رقمية',
        'أجهزة ألعاب'
    ];

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(static::$arabicCategories);
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'status' => $this->faker->boolean(80),
            'parent' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}