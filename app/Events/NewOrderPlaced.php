<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        // Load all relationships needed by the kitchen card
        $this->order = $order->load(['table', 'items.menuItem']);
    }

    /**
     * Which channel to broadcast on.
     * 'kitchen' is a public channel — all kitchen screens listen to it.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('kitchen');
    }

    /**
     * The event name the frontend JavaScript listens for.
     */
    public function broadcastAs(): string
    {
        return 'new-order';
    }

    /**
     * The data sent to the browser with the event.
     * This is everything the kitchen card needs to render.
     */
    public function broadcastWith(): array
    {
        return [
            'order' => [
                'id'           => $this->order->id,
                'order_number' => $this->order->order_number,
                'table_name'   => $this->order->table_id->name,
                'notes'        => $this->order->notes,
                'total'        => $this->order->total,
                'created_at'   => $this->order->created_at->timestamp,
                'items'        => $this->order->items->map(fn($item) => [
                    'name'      => $item->menuItem->name,
                    'quantity'  => $item->quantity,
                    'notes'     => $item->notes,
                ])->toArray(),
            ],
        ];
    }
}