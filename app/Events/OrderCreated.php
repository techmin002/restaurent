<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Modules\Restaurent\Models\Order;

class OrderCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct(Order $data)
    {
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new Channel('orders-channel');
    }

    public function broadcastAs()
    {
        return 'order-created';
    }
}
