<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private Order $order
    ) {
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['database', 'broadcast'];
    }
    public function toDatabase()
    {
        return [
            'id' => $this?->id,
            'title' => 'New Order',
            'body' => "User {$this->order?->user?->name} has made a new order.",
            'order_id' => $this->order?->id,
            'user_id' => $this->order?->user_id,
            'created_at' => $this->order?->created_at?->diffForHumans(),
        ];
    }
    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this?->id,
            'title' => 'New Order',
            'body' => "User {$this->order?->user?->name} has made a new order. Order - {$this->order?->id}",
            'order_id' => $this->order?->id,
            'user_id' => $this->order?->user_id,
            'created_at' => $this->order?->created_at?->diffForHumans(),
        ]);
    }
}
