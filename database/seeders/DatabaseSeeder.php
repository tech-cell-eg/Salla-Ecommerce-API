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

        // Seed Tags
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
        Brand::factory()->count(5)->create();

        // Seed Categories - Manually create them to ensure uniqueness
        $parentCategories = [
            ['name' => '2حواسيب محمولة'],
            ['name' => '2هواتف ذكية'],
            ['name' => '2ساعات ذكية'],
        ];
        
        $createdParents = [];
        foreach ($parentCategories as $category) {
            $createdParents[] = Category::create([
                'name' => $category['name'],
                'slug' => \Illuminate\Support\Str::slug($category['name']),
                'status' => true,
                'parent' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ])->id;
        }
        
        // Then create child categories
        $childCategories = [
            ['name' => '1حواسيب مكتبية', 'parent' => $createdParents[0]],
            ['name' => '1سماعات أجهزة', 'parent' => $createdParents[1]],
            ['name' => '1أجهزة ألعاب', 'parent' => $createdParents[2]],
        ];
        
        foreach ($childCategories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => \Illuminate\Support\Str::slug($category['name']),
                'status' => true,
                'parent' => $category['parent'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Seed Attributes and Attribute Values
        Attribute::factory()->count(5)->create(); // Creates attributes with 2–5 values each

        // Seed Products
        Product::factory()->count(5)->create();

        // Seed Coupons
        Coupon::factory()->count(5)->create();

        // Seed Sliders
        Slider::factory()->count(5)->create();

        // Seed Features
        Feature::factory()->count(5)->create();

        // Seed Users and Roles
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}