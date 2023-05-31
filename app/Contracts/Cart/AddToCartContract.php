<?php

namespace App\Contracts\Cart;

use App\Models\Cart;
use App\Models\User;

interface AddToCartContract
{
    public function handle(array $itemData, User $user): Cart;
}
