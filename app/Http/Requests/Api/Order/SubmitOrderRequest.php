<?php

namespace App\Http\Requests\Api\Order;

use App\Contracts\Cart\GetCartContract;
use App\Helpers\HandlesValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SubmitOrderRequest extends FormRequest
{
    use HandlesValidationResponse;
    public function __construct(
        private GetCartContract $getCartContract,
    ) {
        parent::__construct();
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $cart = $this->getCartContract?->getCartByUserId(auth()?->id());
            $productsInCart = $this->getCartContract->getCartItemsByCartId($cart?->id, 'product:id,name,quantity');
            foreach ($productsInCart as $productInCart) {
                $product = $productInCart->product;
                if (!$product->isAvailable($productInCart->quantity)) {
                    $validator->errors()->add('product', "Product '{$product->name}' quantity is not enough, available quantity is {$product->quantity}");
                }
            }
        });
    }
}
