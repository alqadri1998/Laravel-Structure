<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class newAdminNotifications implements ShouldBroadcast
{
    use SerializesModels;

    public $notification;
    public $admin;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notification, $admin)
    {
        $this->notification = $notification;
        $this->admin = $admin;
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        logger('event broadcasted');
        return new PrivateChannel('sd-tyres-admin-'.$this->admin);
    }

    public function broadcastAs()
    {
        return 'newNotificationEvent';
    }

    public function broadcastWith()
    {
        return ['id' => $this->admin];
    }
}
