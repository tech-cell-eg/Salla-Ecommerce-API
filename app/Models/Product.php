<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Product extends Model
{
    use HasFactory, Sluggable, FilterTrait;

    protected $casts = [
        'status' => 'boolean',
        'has_variants' => 'boolean',
        'has_discount' => 'boolean',
        'manage_stock' => 'boolean',
        'available_in_stock' => 'boolean',
        'start_discount' => 'date',
        'end_discount' => 'date',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,  
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getRemainingQuantityAttribute()
    {
        return $this->quantity - $this->purchased;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getReviewsAverageAttribute()
    {
        return $this->reviews()->avg('rate') ?? 0;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function relatedProducts()
    {
        return Product::where('category_id', $this->category_id)->where('id', '!=', $this->id)->get();
    }

    
    public function getDefaultVariantAttribute()
    {
        return $this->variants()->where('is_default', true)->first();
    }
}
