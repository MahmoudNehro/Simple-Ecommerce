<?php

namespace App\Http\Controllers\Api\Order;

use App\Contracts\Cart\GetCartContract;
use App\Contracts\Order\SubmitOrderContract;
use App\Helpers\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\SubmitOrderRequest;
use App\Http\Resources\Order\OrderResource;
use Illuminate\Contracts\Support\Responsable;

class OrderController extends Controller
{
    public function __construct(
        private GetCartContract $getCartContract,
        private SubmitOrderContract $submitOrderContract,
    ) {
    }
    /**
     * Store a newly created resource in storage.
     */
    public function __invoke(SubmitOrderRequest $request): Responsable
    {
        $cart = $this->getCartContract->getCartByUserId(auth()->id(), 'cartItems:id,quantity,product_id,cart_id');
        if (!$cart) {
            return new MessageResponse(
                message: 'Cart is empty',
                body: [
                    'order' => (object) []
                ],
            );
        }
        $order = $this->submitOrderContract->handle($cart, auth()->user());
        return new MessageResponse(
            message: 'Order submitted successfully',
            body: [
                'order' => OrderResource::make($order)
            ],
        );
    }
}
