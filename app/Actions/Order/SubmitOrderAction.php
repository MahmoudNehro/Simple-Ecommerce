<?php

namespace App\Actions\Order;

use App\Contracts\Order\SubmitOrderContract;
use App\Exceptions\OrderException;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SubmitOrderAction implements SubmitOrderContract
{    

    public function handle(Cart $cart, User $user): Order
    {
        DB::beginTransaction();
        try {
            $cartItems = $cart->cartItems;
            $order =  $this->createOrder($cart, $user);
            $this->insertOrderItems($order, $cartItems);
            $this->updateProductQuantities($cartItems);
            $cart->delete();
            $admin = User::where('is_admin', true)->first();
            Notification::send($admin, new NewOrderNotification($order));
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            Log::debug("message: {$e->getMessage()}, file: {$e->getFile()}, line: {$e->getLine()}");
            //inform the user just that something went wrong, and log the error details in the file
            throw new OrderException();
        }
    }
    private function createOrder(Cart $cart, User $user): Order
    {
        return Order::create([
            'user_id' => $user->id,
            'total_price' => $cart->total_price,
            'total_quantity' => $cart->total_quantity,
        ]);
    }
    private function insertOrderItems(Order $order, $cartItems): void
    {
        $orderItemsData = $cartItems->map(function ($item) use ($order) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'order_id' => $order->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        OrderItem::insert($orderItemsData);
    }
    /**
     * using raw query to update product quantities, because we need to make a single query to update all products quantities
     * using bindings to prevent sql injection
     * Set case when to update all quantities with a single query
     */
    private function updateProductQuantities(Collection $cartItems): void
    {
        $productQuantities = [];
        foreach ($cartItems as $cartItem) {
            $productQuantities[$cartItem->product_id] = $cartItem->quantity;
        }
        $updateCases = [];
        $bindings = [];
        $productIds = [];
        $productIdsBindings = '';
        foreach ($productQuantities as $productId => $quantity) {
            $updateCases[] = "WHEN ? THEN quantity - ?";
            $bindings[] = $productId;
            $bindings[] = $quantity;
            $productIds[] = $productId;
            if (next($productQuantities) === false) {
                $productIdsBindings .= '?';
            } else {
                $productIdsBindings .= '?,';
            }
        }
        array_push($bindings, ...$productIds);
        $updateQuery = "CASE id " . implode(" ", $updateCases) . " END";
        $productIds = implode(',', array_keys($productQuantities));
        DB::update("UPDATE products SET quantity = $updateQuery WHERE `id` in ({$productIdsBindings})", $bindings);
    }
}
