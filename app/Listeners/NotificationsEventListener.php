<?php

namespace App\Listeners;

use App\Events\Notifications;
use App\Jobs\SendEmail;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\Template;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Traits\EMails;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;

class NotificationsEventListener
{
    use EMails;
    protected $views;
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
     * @param  Notifications  $event
     * @return void
     */
    public function handle(Notifications $notification)
    {
        $url = $notification->url;
        $event = $notification->event;
        $eventData = config('events.eventData.'.$event);
        $currentAdminData = session('ADMIN_DATA');
        if (\Config::has('adminEmailOnsiteNotification.'.$event)){
            $data = config('adminEmailOnsiteNotification.'.$event);
            unset($data['users'][$currentAdminData['id']]);
            if (in_array('on_site', $data['notifications'])){
                foreach ($data['users'] as $userId=>$value){
                    Notification::create([
                        'user_id' => $userId,
                        'title' => $eventData['title'],
                        'description' => $eventData['description'],
                        'url' => $url,
                        'is_read' => 0
                    ]);
                }
            }
            if (in_array('email', $data['notifications'])) {
                $emailTemplate = Template::where(['title' => 'notifications'])->pluck('template')->first();
                if(count($emailTemplate) > 0){
                    foreach ($data['users'] as $userId => $userData){
                        $emailData = [
                            'receiver_email' => $userData['email'],
                            'url' => $url,
                            'description' => $eventData['description'],
                            'receiver_name' => $userData['full_name'],
                            'sender_name' => $currentAdminData['full_name'],
                        ];
                        $emailData['template'] = parseAsBlade($emailTemplate);
//                        SendEmail::dispatch($emailData, 'emails.index', $eventData['title'], $userData['email'], $currentAdminData['email']);
//
                        $this->sendMail($emailData, 'emails.index', $eventData['title'], $userData['email'], $currentAdminData['email']);
                    }
                }
            }
        }
    }
}

