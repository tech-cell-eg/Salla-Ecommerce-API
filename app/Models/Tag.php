<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = self::createArabicSlug($tag->name);
            }
        });
    }
    
    /**
     * Create a URL-friendly slug from Arabic text
     */
    public static function createArabicSlug(string $text): string
    {
        // Remove any non-alphanumeric characters and replace spaces with hyphens
        $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        $text = trim($text, '-');
        
        return $text;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags', 'tag_id', 'product_id')
            ->withTimestamps();
    }
}