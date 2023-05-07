<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Notifications' => [
            'App\Listeners\NotificationsEventListener',
        ],
        'App\Events\newNotifications' => [
            'App\Listeners\newNotificationsEventListener',
        ],
        'App\Events\newAdminNotifications' => [
            'App\Listeners\newAdminNotificationsEventListener',
        ],
        'App\Events\CartChangeNotifications' => [
            'App\Listeners\CartChangeNotificationsEventListener',
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class =>
            [ 'SocialiteProviders\\Instagram\\InstagramExtendSocialite@handle', ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
