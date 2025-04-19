<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends  ApiController
{
    public function store(CheckoutRequest $request)
    {
        $cartId = CartService::getCartId();
        
        //return DB::transaction(function () use ($request, $cartId) {
            // Get cart items with product details
            $cartItems = CartService::getCartData();
            if ($cartItems->isEmpty()) {
                abort(422, 'Your cart is empty');
            }
           
            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'user_name' => $request->name,
                'user_phone' => $request->phone,
                'user_email' => $request->email,
                'total_price' => $this->calculateTotal($cartItems),
                'note' => $request->note,
                'country' => $request->country,
                'governorate' => $request->governorate,
                'city' => $request->city,
                'street' => $request->street,
            ]);
            
            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_desc' => $cartItem->product->description,
                    'product_quantity' => $cartItem->quantity,
                    'product_price' => $cartItem->discounted_price ?? $cartItem->price,
                    'data' => $cartItem->product->only(['sku', 'image']),
                ]);
            }
            
            // Dispatch event for post-processing
            event(new OrderCreated($order, $cartItems));
            
            // Clear the cart
            Cart::where('session_id', $cartId)->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'order_id' => $order->id,
            ]);
       // });
    }
    protected function calculateTotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            return ($item->discounted_price ?? $item->price) * $item->quantity;
        });
    }
}
