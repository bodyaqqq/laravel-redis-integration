<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotification implements ShouldQueue
{
    use Queueable;

    public int $id;
    public string $item;
    public int $qty;

    public function __construct(Order $order)
    {
        $this->id = $order->id;
        $this->item = $order->item;
        $this->qty = $order->qty;
    }

    public function handle(): void
    {
        
    }
}