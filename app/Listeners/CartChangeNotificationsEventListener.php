<?php

namespace App\Listeners;

use App\Events\CartChangeNotifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CartChangeNotificationsEventListener
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
     * @param  CartChangeNotifications  $event
     * @return void
     */
    public function handle(CartChangeNotifications $event)
    {
        //
    }
}
