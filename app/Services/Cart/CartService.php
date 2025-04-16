<?php

namespace App\Services\Cart;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Models\Cart;

class CartService
{
    public static function getCartId()
    {
        $id = request()->header('X-Cart-ID') ?? request()->cart_id ?? request()->cookie('cart_id');

        if (!$id) {
            $id = Str::uuid();
            Cookie::queue('cart_id', $id, 60 * 24 * 30);
        }

        return $id;
    }

    public static function getCartData()
    {
        return Cart::with('product')->where('session_id', self::getCartId())->get();
    }

    public static function deleteCart()
    {
        Cart::where('session_id', self::getCartId())->delete();
    }
}
