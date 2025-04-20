<?php 
namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductDetail;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected static $arabicProducts = [
        'حاسوب محمول ديل اكس بي اس 15 بوصة',
        'هاتف سامسونج جالاكسي S22 الترا',
        'ساعة آبل الذكية سيريس 7',
        'حاسوب مكتبي ايسر بريداتور',
        'هاتف شاومي ريدمي نوت 11 برو',
        'سماعات ابل ايربودز برو',
        'لوحة مفاتيح ميكانيكية لوجيتك',
        'ماوس لاسلكي من مايكروسوفت',
        'شاشة ال جي 27 بوصة 4K',
        'حاسوب محمول ماك بوك برو M1',
        'هاتف اوبو فايند X5',
        'ساعة هواوي الذكية GT 3',
        'حاسوب محمول لينوفو ليجيون',
        'هاتف نوكيا G21',
        'سماعات سوني WH-1000XM4'
    ];

    protected static $arabicDescriptions = [
        'أداء قوي وتصميم أنيق مع شاشة عالية الدقة',
        'كاميرات احترافية وبطارية تدوم طوال اليوم',
        'تتبع دقيق للنشاط البدني ومقاومة للماء',
        'مواصفات عالية للألعاب وتصميم جذاب',
        'أداء سريع وشاشة AMOLED ممتازة',
        'جودة صوت عالية مع إلغاء ضجيج فعال',
        'أزرار ميكانيكية دقيقة مع إضاءة RGB',
        'تصميم مريح ودقة تتبع عالية',
        'ألوان دقيقة وزوايا مشاهدة واسعة',
        'معالج M1 السريع مع عمر بطارية ممتد',
        'شاشة منحنية وكاميرات متطورة',
        'تتبع صحي متكامل وتصميم أنيق',
        'أداء عالي للاعبين المحترفين',
        'بطارية تدوم يومين مع شاشة كبيرة',
        'إلغاء ضجيج متطور وجودة صوت مذهلة'
    ];

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(static::$arabicProducts);
        $hasVariants = $this->faker->boolean(30);
        $hasDiscount = $this->faker->boolean(20);
        $manageStock = $this->faker->boolean(50);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'small_desc' => $this->faker->randomElement(static::$arabicDescriptions),
            'description' => implode("\n\n", array_map(function($item) {
                return $this->faker->randomElement([
                    '• ' . $item,
                    '✓ ' . $item,
                    '▶ ' . $item
                ]);
            }, $this->faker->randomElements(static::$arabicDescriptions, 3))),
            'status' => $this->faker->boolean(80),
            'sku' => $this->faker->unique()->bothify('SKU-####-??'),
            'has_variants' => $hasVariants,
            'price' => $hasVariants ? null : $this->faker->randomFloat(3, 500, 10000),
            'has_discount' => $hasDiscount,
            'discount' => $hasDiscount ? $this->faker->randomFloat(2, 5, 30) : null,
            'start_discount' => $hasDiscount ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'end_discount' => $hasDiscount ? $this->faker->dateTimeBetween('now', '+1 month') : null,
            'manage_stock' => $manageStock,
            'quantity' => $manageStock ? $this->faker->numberBetween(0, 50) : null,
            'purchased' => $this->faker->numberBetween(0, 200),
            'available_in_stock' => $this->faker->boolean(90),
            'category_id' => Category::factory()->create()->id,
            'brand_id' => Brand::factory()->create()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($product) {
            ProductImage::factory()->count($this->faker->numberBetween(2, 5))->create([
                'product_id' => $product->id,
            ]);
            
            // Realistic product details for electronics
            $details = [
                ['key' => 'اللون', 'value' => $this->faker->randomElement(['أسود', 'فضي', 'أبيض', 'أزرق', 'ذهبي'])],
                ['key' => 'الوزن', 'value' => $this->faker->randomElement(['1.2 كجم', '800 جرام', '2.5 كجم', '350 جرام'])],
                ['key' => 'البطارية', 'value' => $this->faker->randomElement(['5000 مللي أمبير', '4000 مللي أمبير', '6000 مللي أمبير', '12 ساعة عمل'])],
            ];
            
            foreach ($details as $detail) {
                ProductDetail::factory()->create([
                    'product_id' => $product->id,
                    'key' => $detail['key'],
                    'value' => $detail['value'],
                ]);
            }

            $tags = Tag::inRandomOrder()->take($this->faker->numberBetween(2, 5))->get();
            $product->tags()->attach($tags->pluck('id'));
            
            Review::factory()->count($this->faker->numberBetween(1, 5))->create([
                'product_id' => $product->id,
                'user_id' => User::factory()->create()->id,
            ]);

            if ($product->has_variants) {
                $variants = ProductVariant::factory()->count($this->faker->numberBetween(1, 3))->create([
                    'product_id' => $product->id,
                    'is_default' => fn($index) => $index === 0,
                ]);
                
                foreach ($variants as $variant) {
                    $attributeValues = AttributeValue::factory()->count($this->faker->numberBetween(1, 2))->create([
                        'attribute_id' => Attribute::inRandomOrder()->first()->id,
                    ]);
                    $variant->attributeValues()->attach($attributeValues->pluck('id'));
                }
            }
        });
    }
}