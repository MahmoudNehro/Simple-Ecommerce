<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\UpdateCartItemContract;
use App\Exceptions\OrderException;
use App\Models\CartItem;
use App\Models\Cart;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateCartItemAction implements UpdateCartItemContract
{
    public function handle(Cart $cart, CartItem $cartItem, int $quantity): Cart
    {
        DB::beginTransaction();
        try {
            CartItem::where('id', $cartItem->id)->update(['quantity' => $quantity]);
            $oldCartItemPrice = $cartItem->product?->price * $cartItem->quantity;
            $newCartItemPrice = $cartItem->product?->price * $quantity;
            $cart->total_price = $cart->total_price - $oldCartItemPrice + $newCartItemPrice;
            $cart->total_quantity = $cart->total_quantity - $cartItem->quantity + $quantity;
            $cart->save();
            DB::commit();
            return $cart;
        } catch (Exception $e) {
            Log::debug("message: {$e->getMessage()}, file: {$e->getFile()}, line: {$e->getLine()}");
            throw new OrderException();
        }
    }
}
