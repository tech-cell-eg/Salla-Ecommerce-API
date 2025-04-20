<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected static $arabicBrands = [
        'سامسونج',
        'ابل',
        'هواوي',
        'شاومي',
        'ديل',
        'ايسر',
        'لينوفو',
        'اتش بي',
        'سوني',
        'نوكيا',
        'اوppo',
        'فيvo',
        'ريلمي',
        'وان بلس',
        'اسوس'
    ];

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(static::$arabicBrands);
        return [
            'name' => $name,
            'logo' => $this->faker->imageUrl(200, 200, 'logo', true, strtolower($name)),
            'status' => $this->faker->boolean(90),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}