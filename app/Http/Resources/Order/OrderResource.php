<?php

namespace App\Http\Resources\Order;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_items' => OrderItemResource::collection($this->orderItems()->with('product')->get()),
        ];
    }
}
