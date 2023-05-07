<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CartChangeNotifications implements ShouldBroadcast
{
    use SerializesModels;

    public $notification;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notification, $user)
    {
        $this->notification = $notification;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        logger('event broadcasted');
        return new PrivateChannel('sd-tyres-cart-'.$this->user);
    }

    public function broadcastAs()
    {
        return 'newCartNotificationEvent';
    }

    public function broadcastWith()
    {
        return ['id' => $this->user];
    }
}
