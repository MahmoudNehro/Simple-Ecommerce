<?php

namespace App\Contracts\Cart;

use App\Models\Cart;
use App\Models\CartItem;

interface RemoveItemContract
{
    public function handle(Cart $cart, CartItem $cartItem): ?Cart;
}
