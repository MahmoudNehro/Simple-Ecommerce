<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'name' => (string) $this->product?->name,
            'price' => (float) round($this->product?->price,3),
            'quantity' => (int) $this->quantity,
            'image' => (string) $this->product?->image,
            'product_id' => (int) $this->product_id
        ];
    }
}
