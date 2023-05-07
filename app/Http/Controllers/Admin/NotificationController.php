<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class NotificationController extends Controller
{
    public function __construct() {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbTitle = 'Notifications';
        $this->breadcrumbs[route('admin.notifications.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }
    public function index() {
        $where = ['admin_id' =>env('Admin_id')];
        $notifications = Notification::whereHas('languages')->with('languages')->where($where)->orderBy('created_at','DESC')->paginate(10);
        foreach ($notifications as $key =>$value){
            $value->time  = Carbon::createFromTimestamp($value->created_at)->diffForHumans();
        }
        $this->setTranslations($notifications);
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-files-o', 'title' => 'Manage Notifications'];
        return view('admin.notifications.index', ['notifications'=>$notifications]);
    }
    public function edit($event) {
        $users = [];
        $heading = (($event !== "0") ? 'Edit Notification':'Add Notification');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-files-o', 'title' => $heading];
        $userData = Admin::all();
        $events = $this->getViewParams('events');
        $notifications = $this->getViewParams('notifications');
        foreach ($userData as $key=>$user){
            $users[$user->id] = $user->full_name;
        }
        /*===============================Default Values===================================*/
        $selectedEvents = ($event != "0") ? $this->getViewParams('events', $event) : [];
        $selectedNotifications = (count($selectedEvents) > 0) ? array_values($selectedEvents['notifications']) : [];
        $selectedUsers = (count($selectedEvents) > 0) ? array_keys($selectedEvents['users']) : [];
        return view('admin.notifications.edit', [
            'action'=>route('admin.notifications.update', ['event'=>$event]),
            'users'=>$users, 'events'=>$events, 'notifications'=>$notifications,
            'selectedUsers'=>$selectedUsers, 'selectedNotifications'=>$selectedNotifications,
            'selectedEvents'=>$event
        ]);
    }

    public function update(Request $request) {
        $err = $this->save($request);
        return ($err) ? $err:redirect(route('admin.notifications.index'))->with('status', 'Notification has been Updated.');
    }

    private function save($request)
    {
        $data = [];
        $users = [];
        $requestUsers = $request->get('users');
        foreach ($requestUsers as $key=>$userId){
            $user = Admin::where(['id'=>$userId])->select('email', 'full_name')->first();
            $users[$userId]['email'] = $user->email;
            $users[$userId]['full_name'] = $user->full_name;
        }
        foreach ($request->get('events') as $key=>$event){
            $data[$event]['users'] = $users;
            $data[$event]['notifications'] = $request->get('notifications');
        }
        foreach ($request->get('events') as $key=>$event){
            \Config::set('adminEmailOnsiteNotification.'.$event, $data[$event]);
        }
        $notifications = serialize(config('adminEmailOnsiteNotification'));
        $file = base_path('config/adminEmailOnsiteNotification.php');
        $data = "<?php return unserialize(base64_decode('".base64_encode($notifications)."'));";
        file_put_contents($file, $data);
        return redirect('admin/notifications')->with('status', 'Notifications have been updated');
    }

    public function store(Request $request) {
        $err = $this->save($request);
        return ($err) ? $err:redirect(route('admin.templates.index'))->with('status', 'Translation saved');
    }

    public function destroy($event) {
        $notifications = config('adminEmailOnsiteNotification');
        array_forget($notifications,$event);
        $notifications = serialize($notifications);
        $file = base_path('config/adminEmailOnsiteNotification.php');
        $data = "<?php return unserialize(base64_decode('".base64_encode($notifications)."'));";
        file_put_contents($file, $data);
        return redirect('admin/notifications')->with('status', 'Notifications have been updated');
    }

    private function getViewParams($key, $event = "0"){
        $data = [];
        if ($key == 'events'){
            $key .= '.events';
        }else{
            $key .= '.notifications';
        }
        $keyData = ($event == "0") ? config($key) : config('adminEmailOnsiteNotification.'.$event);
        if ($event != "0"){
            return $keyData;
        }else{
            foreach ($keyData as $key=>$keys){
                $data[$keys] = ucwords(str_replace('_', ' ', $keys));
            }
            return $data;
        }
    }
}
