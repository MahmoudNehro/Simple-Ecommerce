<?php

namespace App\Contracts\Cart;

use App\Models\Cart;
use App\Models\CartItem;

interface UpdateCartItemContract
{
    public function handle(Cart $cart ,CartItem $cartItem, int $quantity): Cart;
}