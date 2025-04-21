<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductResource;
use App\Filters\Website\ProductFilter;

class ProductController extends ApiController
{
    public function index(ProductFilter $filters)
    {
        return ApiController::successResponse([
            "data" => ProductResource::collection(Product::with('category', 'images', 'brand','reviews')->latest()->filter($filters)->get()),
            'message' => 'Products fetched successfully'
        ], 200);
    }
    public function show($product)
    {
       
        $productModel=Product::with('category', 'images', 'brand','reviews')->findOrFail($product);
        return ApiController::successResponse([
            "data" => new ProductResource( $productModel),
            'message' => 'Product fetched successfully'
        ], 200);
    }

    public function newArrivals()
    {
      
        $products = Product::where('is_new_arrival', true)
            ->with(['images', 'brand', 'category','reviews']) // eager load relationships
            ->latest('created_at')
            ->get();

        return response()->json([
            'success' => true,
           "data" => ProductResource::collection($products),
        ]);
    }
}
