<?php

namespace App\Events;

use App\Conekta\Billable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProcessPurchase
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $billable = null;
    public $payment = null;
    public $customer = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($billable, $payment, $customer)
    {
        $this->billable = $billable;
        $this->payment  = $payment;
        $this->customer = $customer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
