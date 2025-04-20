<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    protected static $arabicTags = [
        'تخفيضات',
        'جديد',
        'الأكثر مبيعاً',
        'مميز',
        'عروض خاصة',
        'أجهزة كمبيوتر',
        'هواتف',
        'ساعات ذكية',
        'ملحقات',
        'ألعاب',
        'تصوير',
        'شبكات',
        'برمجة',
        'تصميم',
        'تعليم'
    ];

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(static::$arabicTags);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}