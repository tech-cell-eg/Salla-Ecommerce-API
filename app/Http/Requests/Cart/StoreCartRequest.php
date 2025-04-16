<?php

namespace App\Http\Requests\Cart;

use App\Models\Product;
use App\Rules\NoDuplicateCartItem;
use App\Services\Cart\CartService;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        $product = Product::findOrFail($validated['product_id']);
        $price = $product->price ? $product->price : $product->default_variant->price;
        
        return array_merge($validated, [
            'session_id' => CartService::getCartId(),
            'price' => $price,
            'discounted_price' => $product->discount ? $product->discount : $price,
        ]);
    }
}
