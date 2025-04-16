<?php 

namespace App\Services;

use App\Exceptions\CustomExceptions;
use App\Models\Coupon;
use App\Models\Product;
use Carbon\Carbon;

class CouponService
{
  
    // Get active offers for a product
    public function getActiveOffer(Product $product)
    {
        return Coupon::Where(function ($query) use ($product) {
                // Offers that apply to the product's category
                $query->where('category_id', $product->category_id)
                        ->where('start_date', '<=', Carbon::now())
                        ->where('end_date', '>=', Carbon::now());
            })
            ->orWhere(function ($query) use ($product) {
                // Offers that apply specifically to this product
                $query->where('product_id', $product->product_id)
                ->where('start_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now());
            })
            ->orderBy('created_at', 'desc') // Get the latest offer first
            ->first(); // Get just the first (most recent) one
    }
        
}