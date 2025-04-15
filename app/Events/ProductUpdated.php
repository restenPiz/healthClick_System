<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    public function __construct($product)
    {
        $this->product = $product;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('products'),
        ];
    }
    public function broadcastWith()
    {
        return ['product' => $this->product];
    }
}
