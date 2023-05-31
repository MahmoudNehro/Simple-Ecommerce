<?php

namespace App\Http\Requests\Api\Cart;

use App\Contracts\Cart\GetCartContract;
use App\Helpers\HandlesValidationResponse;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AddToCartRequest extends FormRequest
{
    use HandlesValidationResponse;

    public function __construct(
        private GetCartContract $getCartContract
    ) {
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->has('product_id') && $this->has('quantity') && !$validator->errors()->has('product_id') && !$validator->errors()->has('quantity')) {
                $product = Product::find($this->product_id);
                $cart = $this->getCartContract->getCartByUserId(auth()->id());
                $productInCart = $this->getCartContract->getOneCartItem($cart?->id, $this?->product_id)->first();
                if (!$product->isAvailable($this->quantity) || ($productInCart && $product->quantity < $productInCart->quantity + $this->quantity)) {
                    $validator->errors()->add('quantity', "Product quantity is not enough, available quantity is {$product->quantity}");
                }
            }
        });
    }
}
