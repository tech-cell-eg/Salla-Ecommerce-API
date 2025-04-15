<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => 'boolean',
        'has_variants' => 'boolean',
        'has_discount' => 'boolean',
        'manage_stock' => 'boolean',
        'available_in_stock' => 'boolean',
        'start_discount' => 'date',
        'end_discount' => 'date',
    ];

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
}
