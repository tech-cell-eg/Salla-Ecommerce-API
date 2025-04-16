<?php

namespace App\Rules;

use Closure;
use App\Models\Cart;
use App\Services\Cart\CartService;
use Illuminate\Contracts\Validation\ValidationRule;

class NoDuplicateCartItem implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cartItem = Cart::where([
            'product_id' => $value,
            'session_id' => CartService::getCartId()
        ])->exists();

        if ($cartItem) {
            $fail('This product is already in your cart.');
        }
    }
}
