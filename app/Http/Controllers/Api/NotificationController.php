<?php

namespace App\Http\Controllers\Api;

use App\Http\Libraries\ResponseBuilder;
use App\Models\LanguageNotification;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function notifications()
    {
        $user = JWTAuth::user();
        if ($user instanceof User) {
            $where = ['user_id' => $user->id];
        } else {
            $where = ['admin_id' => 1];
        }
        $notifications = Notification::whereHas('languages')->with('languages')->where($where)->orderBy('created_at', 'DESC')->paginate(10);
        foreach ($notifications as $key => $value) {
            $value->time = Carbon::createFromTimestamp($value->created_at)->diffForHumans();
        }
        $this->setTranslations($notifications);
        $response = new ResponseBuilder(200, 'Notifications', $notifications);
        return $response->build();
    }

    public function notificationCount($type = '')
    {
        $user = JWTAuth::user();
        if ($user instanceof User) {
            $where = ['user_id' => $user->id, 'is_seen' => 0];
        } else {
            $where = ['admin_id' => 1, 'is_seen' => 0];
        }
        $notifications['count'] = Notification::whereHas('languages')->with('languages')->where($where)->count();
        $response = new ResponseBuilder(200, 'Notifications count', $notifications);
        return $response->build();
    }

    public function isSeen()
    {
        $user = JWTAuth::user();
        if ($user instanceof User) {
            $where = ['user_id' => $user->id, 'is_seen' => 0];
        } else {
            $where = ['admin_id' => 1, 'is_seen' => 0];
        }
        $notification = Notification::where($where)->update(['is_seen' => 1]);
        $response = new ResponseBuilder(200, 'notification seen');
        return $response->build();
    }

    public function isViewed($notificationId = '')
    {
        $notification = Notification::where('id', $notificationId)->update(['is_read' => 1]);
        $response = new ResponseBuilder(200, 'notification viewed');
        return $response->build();
    }

    public function deleteNotification($id)
    {
        $notification = Notification::find($id);
        $notification->languages()->detach();
        $notification->delete();
        $response = new ResponseBuilder(200, 'notification deleted');
        return $response->build();
    }

    public function clearAll()
    {
        $user = JWTAuth::user();
        if ($user instanceof User) {
            $where = ['user_id' => $user->id];
        } else {
            $where = ['admin_id' => 1];
        }
        $notifications = Notification::where($where)->pluck('id');
        $notificationIds = $notifications->toArray();
        LanguageNotification::whereIn('notification_id', $notificationIds)->delete();
        $notifications = Notification::where($where)->delete();
        $response = new ResponseBuilder(200, 'notification deleted');
        return $response->build();
    }

}

