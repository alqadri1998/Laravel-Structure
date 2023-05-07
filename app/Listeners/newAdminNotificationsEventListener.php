<?php

namespace App\Listeners;

use App\Events\newAdminNotifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class newAdminNotificationsEventListener
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
     * @param  newAdminNotifications  $event
     * @return void
     */
    public function handle(newAdminNotifications $event)
    {
        //
    }
}
