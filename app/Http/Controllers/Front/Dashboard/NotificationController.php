<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationController extends Controller
{
    public function __construct() {
        parent::__construct();
              $this->breadcrumbs[route('front.dashboard.index')] = ['title' => __('Profile')];

    }

    public function index(){
        $this->breadcrumbTitle = __('Notifications');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Notifications')];
        $user = JWTAuth::user();
        $where = ['user_id' => $user->id];
        $notifications = Notification::whereHas('languages')->with('languages')->where($where)->orderBy('created_at','DESC')->paginate(10);
        foreach ($notifications as $key =>$value){
            $value->time  = Carbon::createFromTimestamp($value->created_at)->diffForHumans();
        }
        $this->setTranslations($notifications);
        return view('front.dashboard.notification',['notifications' => $notifications]);
    }
}
