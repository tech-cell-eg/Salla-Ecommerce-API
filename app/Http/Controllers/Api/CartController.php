<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Services\Cart\CartService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;

class CartController extends Controller
{
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

        return response([
            'status' => 'success',
            'message' => 'Product added to cart successfully',
            'cartItemsNumber' => Cart::where('session_id', $cartId)->count(),
            'cart_id' => $cartId
        ], 201)->header('X-Cart-ID', $cartId);
    }
}