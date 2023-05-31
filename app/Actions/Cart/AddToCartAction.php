<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\AddToCartContract;
use App\Contracts\Cart\GetCartContract;
use App\Exceptions\OrderException;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddToCartAction implements AddToCartContract
{
    public function __construct(
        private GetCartContract $getCartContract
    ) {
    }
    public function handle(array $itemData, User $user): Cart
    {
        DB::beginTransaction();
        try {
            $cart = $this->getCartContract->getCartByUserId($user->id, 'cartItems');
            $cartItem = $cart?->cartItems?->where('product_id', $itemData['product_id'])?->first()
                ?? $this->getCartContract->getOneCartItem($cart?->id, $itemData['product_id'])->first();
            $product = Product::find($itemData['product_id']);
            $cartItemPrice = $product->price * $itemData['quantity'];
            $totalPrice = $cart ? $cart->total_price + $cartItemPrice : $cartItemPrice;
            $totalQuantity = $cart ? $cart->total_quantity + $itemData['quantity'] : $itemData['quantity'];
            $itemQuantity = $cartItem ? $cartItem->quantity + $itemData['quantity'] : $itemData['quantity'];
            
            $cart = $this->updateOrCreateCart($cart, $user, $totalPrice, $totalQuantity);
            $this->updateOrCreateCartItem($cart, $cartItem, $itemData, $itemQuantity);
            DB::commit();
            return $cart;
        } catch (Exception $e) {
            DB::rollback();
            Log::debug("message: {$e->getMessage()}, file: {$e->getFile()}, line: {$e->getLine()}");
            throw new OrderException();
        }
    }
    /**
     * didn't use eloquent updateOrCreate because it performs a select query every time to check if the record exists
     * and we already have the record in the $cart variable
     */
    private function updateOrCreateCart(?Cart $cart, User $user, float $totalPrice, int $totalQuantity): Cart
    {
        if ($cart) {
            $cart->update([
                'total_price' => $totalPrice,
                'total_quantity' => $totalQuantity,
            ]);
            return $cart;
        }
        return Cart::create(
            [
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'total_quantity' => $totalQuantity,
            ]
        );
    }
    private function updateOrCreateCartItem(Cart $cart, ?CartItem $cartItem, array $itemData, int $itemQuantity): void
    {
        if ($cartItem) {
            $cartItem->update([
                'quantity' => $itemQuantity,
            ]);
            return;
        }
        $cart->cartItems()->create(
            [
                'product_id' => $itemData['product_id'],
                'quantity' => $itemQuantity
            ]
        );
    }
}
