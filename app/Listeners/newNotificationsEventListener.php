<?php

namespace App\Listeners;

use App\Events\newNotifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class newNotificationsEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  newNotifications  $event
     * @return void
     */
    public function handle(newNotifications $event)
    {
        //
    }
}
