<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductResource;

class ProductController extends ApiController
{
    public function show(Product $product)
    {
        return ApiController::successResponse([
            "data" => new ProductResource($product->load('category', 'images', 'brand', 'variants.variantAttributes', 'details', 'tags', 'reviews')),
            'message' => 'Product fetched successfully'
        ], 200);
    }
}
