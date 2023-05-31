<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Cart
 */
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'total_price' => (float) round($this->total_price, 3),
            'total_quantity' => (int) $this->total_quantity,
            'cart_items' => CartItemResource::collection($this->cartItems()->with('product')->get()),
        ];
    }
}
