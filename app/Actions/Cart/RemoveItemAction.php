<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\RemoveItemContract;
use App\Exceptions\OrderException;
use App\Models\Cart;
use App\Models\CartItem;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RemoveItemAction implements RemoveItemContract
{
    public function handle(Cart $cart, CartItem $cartItem): ?Cart
    {
        DB::beginTransaction();
        try {
            CartItem::where('id', $cartItem->id)->where('cart_id', $cart->id)?->delete();
            if ($cart->cartItems()->doesntExist()) {
                $cart->delete();
                DB::commit();
                return null;
            }
            $cart->total_price = $cart->total_price - ($cartItem->quantity * $cartItem->product?->price);
            $cart->total_quantity = $cart->total_quantity - $cartItem->quantity;
            $cart->save();
            DB::commit();
            return $cart;
        } catch (Exception $e) {
            DB::rollback();
            Log::debug("message: {$e->getMessage()}, file: {$e->getFile()}, line: {$e->getLine()}");
            throw new OrderException();
        }
    }
}
