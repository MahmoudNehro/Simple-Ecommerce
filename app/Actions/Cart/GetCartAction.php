<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\GetCartContract;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetCartAction implements GetCartContract
{
    public function getCartByUserId(?int $userId, array|string $relations = []): ?Cart
    {
        return Cart::where('user_id', $userId)->with($relations)->first();
    }
    public function getCartItemsByCartId(?int $cartId, array|string $relations = []): Collection
    {
        return CartItem::where('cart_id', $cartId)->with($relations)->get();
    }
    public function getOneCartItem(?int $cartId, ?int $productId, array|string $relations = []): ?Builder
    {
        return CartItem::where('cart_id', $cartId)->where('product_id', $productId)->with($relations);
    }
}
