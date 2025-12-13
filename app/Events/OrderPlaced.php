<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $message;
    public $userId;

    public function __construct(Order $order, string $message)
    {
        $this->orderId = $order->id;
        $this->message = $message;
        $this->userId = $order->user_id; 
    }
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('users.' . $this->userId);
    }
    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->orderId,
            'message' => $this->message,
        ];
    }
}
