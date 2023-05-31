<?php

namespace App\Contracts\Cart;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface GetCartContract
{
    public function getCartByUserId(?int $userId, array|string $relations = []): ?Cart;
    public function getCartItemsByCartId(?int $cartId, array|string $relations = []): Collection;
    public function getOneCartItem(?int $cartId, ?int $productId, array|string $relations = []): ?Builder;
}
