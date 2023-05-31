<?php
namespace App\Contracts\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;

interface SubmitOrderContract
{
    public function handle(Cart $cart, User $user): Order;
}
