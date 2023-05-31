<?php

namespace App\Http\Controllers\Api\Cart;

use App\Contracts\Cart\AddToCartContract;
use App\Contracts\Cart\GetCartContract;
use App\Contracts\Cart\RemoveItemContract;
use App\Contracts\Cart\UpdateCartItemContract;
use App\Enums\Http;
use App\Helpers\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\AddToCartRequest;
use App\Http\Requests\Api\Cart\UpdateCartItemRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\CartItem;
use Illuminate\Contracts\Support\Responsable;

class CartController extends Controller
{
    public function __construct(
        private GetCartContract $getCartContract,
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Responsable
    {
        $cart = $this->getCartContract->getCartByUserId(auth()->id());
        return new MessageResponse(
            body: [
                'cart' => $cart ? CartResource::make($cart) : (object) []
            ],
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(AddToCartRequest $request, AddToCartContract $addToCartContract): Responsable
    {
        $validated = $request->validated();
        $cart = $addToCartContract->handle($validated, auth()->user());
        return new MessageResponse(
            code: Http::CREATED,
            message: 'Product added to cart successfully',
            body: [
                'cart' => CartResource::make($cart)
            ],
        );
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, CartItem $cartItem, UpdateCartItemContract $updateCartItemContract): Responsable
    {
        $data = $request->validated();
        $cart = $this->getCartContract->getCartByUserId(auth()->id());
        $cartItem = $this->getCartContract->getOneCartItem($cart->id, $cartItem->product_id)->firstOrFail();

        $cart = $updateCartItemContract->handle($cart, $cartItem, $data['quantity']);
        return new MessageResponse(
            message: 'Cart item updated successfully',
            body: [
                'cart' => CartResource::make($cart)
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem, RemoveItemContract $removeItemContract): Responsable
    {
        $cart = $this->getCartContract->getCartByUserId(auth()->id());
        $cartItem = $this->getCartContract->getOneCartItem($cart->id, $cartItem->product_id)->firstOrFail();
        $cart = $removeItemContract->handle($cart, $cartItem);
        return new MessageResponse(
            message: 'Product removed from cart successfully',
            body: [
                'cart' => $cart ? CartResource::make($cart) : (object) []
            ],
        );
    }
}
