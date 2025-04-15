<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function variantAttributes()
    {
        return $this->hasMany(VariantAttribute::class);
    }
    
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attributes', 'product_variant_id', 'attribute_value_id');
    }
}
