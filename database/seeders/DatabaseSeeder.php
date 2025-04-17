<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\User;
use App\Models\ProductImage;
use App\Models\ProductDetail;
use App\Models\ProductTag;
use App\Models\Review;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate all tables
        Brand::truncate();
        Category::truncate();
        Product::truncate();
        ProductImage::truncate();
        ProductDetail::truncate();
        Coupon::truncate();
        Tag::truncate();
        ProductTag::truncate();
        Slider::truncate();
        Feature::truncate();
        Review::truncate();
        Attribute::truncate();
        AttributeValue::truncate();
        ProductVariant::truncate();
        VariantAttribute::truncate();
        User::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed Tags (create all 30 unique tags from TagFactory's $tagNames)
        $tagNames = [
            'electronics', 'fashion', 'home', 'sports', 'outdoor', 'beauty', 'tech', 'gaming',
            'fitness', 'travel', 'kitchen', 'books', 'music', 'health', 'toys', 'jewelry',
            'pets', 'garden', 'office', 'automotive', 'baby', 'crafts', 'food', 'luxury',
            'vintage', 'eco-friendly', 'trending', 'seasonal', 'sale', 'new-arrival',
        ];
        foreach ($tagNames as $name) {
            Tag::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed Brands
        Brand::factory()->count(10)->create();

        // Seed Categories with some parent-child relationships
        Category::factory()->count(5)->create(); // Top-level categories
        Category::factory()->count(10)->create([
            'parent' => Category::inRandomOrder()->first()->id,
        ]); // Subcategories

        // Seed Attributes and Attribute Values
        Attribute::factory()->count(8)->create(); // Creates attributes with 2–5 values each

        // Seed Products (includes images, details, tags, reviews, variants, and variant attributes)
        Product::factory()->count(50)->create();

        // Seed Coupons
        Coupon::factory()->count(10)->create();

        // Seed Sliders
        Slider::factory()->count(5)->create();

        // Seed Features
        Feature::factory()->count(6)->create();
    }
}