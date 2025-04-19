<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Services\Cart\CartService;
use App\Http\Resources\CartResource;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Cart\StoreCartRequest;

class CartController extends ApiController
{

    public function index()
    {
        
        return ApiController::successResponse([
            "data" => CartResource::collection(CartService::getCartData()),
            'message' => 'Cart items fetched successfully'
        ], 200);
    }
    public function store(StoreCartRequest $request)
    {
        $cartId = $request->header('X-Cart-ID') ?? $request->cart_id ?? CartService::getCartId();
        
        Cart::updateOrCreate([
            'session_id' => $cartId,
            'product_id' => $request->product_id
        ], [
            'quantity' => $request->quantity,
            'price' => $request->validated()['price'],
            'discounted_price' => $request->validated()['discounted_price']
        ]);


        $response = response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully',
            'cartItemsNumber' => Cart::where('session_id', $cartId)->count(),
            'cart_id' => $cartId
        ]);
        
        // Set cookies
        $minutes = 60 * 24 * 30; // 30 days
        $response->withCookie(cookie('cart_id', $cartId, $minutes));
              
        
        return $response;
    }
}