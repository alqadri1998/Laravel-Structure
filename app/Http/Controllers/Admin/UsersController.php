<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\Uploader;
use App\Http\Requests\AdminUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Libraries\DataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class UsersController extends Controller {

    public function __construct() {
        parent::__construct('adminData', 'admin');
//        $this->middleware('admin.role:crud', ['only' => ['index']]);
//        $this->middleware('admin.role:crud,0', ['only' => ['all']]);
//        $this->middleware('admin.role:create', ['only' => ['create', 'store']]);
//        $this->middleware('admin.role:read', ['only' => ['show']]);
//        $this->middleware('admin.role:update', ['only' => ['edit', 'update']]);
//        $this->middleware('admin.role:update,0', ['only' => ['toggleStatus']]);
//        $this->middleware('admin.role:delete,0', ['only' => ['destroy']]);
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
        $this->breadcrumbTitle = 'Users';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' => 'Manage Users'];
        return view('admin.users.index');
    }

    public function all() {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'first_name', 'dt' => 'first_name'],
            ['db' => 'email', 'dt' => 'email'],
            ['db' => 'is_active', 'dt' => 'is_active'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
            ['db' => 'deleted_at', 'dt' => 'deleted_at'],

//            ['db' => 'email_verified', 'dt' => 'email_verified']
        ];
        DataTable::init(new User, $columns);
//        DataTable::with('companies');
//        DataTable::where('account_type', '=', 'client');
        $first_name = \request('datatable.query.first_name','');
//        $last_name = \request('datatable.query.last_name','');
        $email = \request('datatable.query.email','');
        $trashedItems = \request('datatable.query.trashedItems',NULL);
        $gender = \request('datatable.query.userGender','');
        $emailStatus = \request('datatable.query.emailStatus','');
        $createdAt = \request('datatable.query.createdAt','');
        $updatedAt = \request('datatable.query.updatedAt','');
        $deletedAt = \request('datatable.query.deletedAt','');

        if(!empty($trashedItems)){
            DataTable::getOnlyTrashed();
        }
        if($first_name != '') {
            DataTable::where('first_name', 'LIKE', '%'.addslashes($first_name).'%');
        }

//        if($emailStatus != '') {
//            DataTable::where('email_verified', '=', $emailStatus);
//        }
        if($email != '') {
            DataTable::where('email', 'like', '%'.addslashes($email).'%');
        }
        if($createdAt != '') {
            $createdAt =  Carbon::createFromFormat('m/d/Y', $createdAt);
            $cBetween = [$createdAt->hour(0)->minute(0)->second(0)->timestamp, $createdAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('created_at', $cBetween);
        }
        if($updatedAt != '') {
            $updatedAt =  Carbon::createFromFormat('m/d/Y', $updatedAt);
            $uBetween = [$updatedAt->hour(0)->minute(0)->second(0)->timestamp, $updatedAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('updated_at', $uBetween);
        }
        if(!empty($deletedAt)){
            $where = function($query) use ($deletedAt) {
                $deletedAt = Carbon::createFromFormat('m/d/Y', $deletedAt);
                $dBetween = [$deletedAt->hour(0)->minute(0)->second(0)->timestamp, $deletedAt->hour(23)->minute(59)->second(59)->timestamp];
                $query->whereBetween('deleted_at',$dBetween);
            };
            DataTable::getOnlyTrashed($where);
        }
        $users = DataTable::get();
        if (sizeof($users['data']) > 0) {
            $dateFormat = config('settings.date-format');
            foreach ($users['data'] as $key => $user) {
//                $users['data'][$key]['email_verified'] = (($user['email_verified'] == 1) ? 'Verified' : 'Unverified') . '</a>';
//                $users['data'][$key]['user_phone'] = $user['user_phone'];

                $users['data'][$key]['created_at'] = Carbon::createFromTimestamp($user['created_at'])->format($dateFormat);
                $users['data'][$key]['updated_at'] = Carbon::createFromTimestamp($user['updated_at'])->format($dateFormat);
                if(!empty($trashedItems)){
                    $users['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill restore-record-button" href="javascript:{};" data-url="' . route('admin.users.restore', $user['id']) . '" title="Restore User"><i class="fa fa-fw fa-undo"></i></a>'.
                        '<span class="m-badge m-badge--danger">'.Carbon::parse($user['deleted_at'])->format($dateFormat).'</span>';
                }else {
                    $users['data'][$key]['actions'] = '<a href="' . route('admin.users.edit',  $user['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.users.destroy',  $user['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' => 'Add User'];

        return view('admin.users.create',[
            'user' => new User(),
            'action' => route('admin.users.store')
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->save($request);
        return redirect(route('admin.users.index'))->with('status', 'User added successfully.');
    }

    /*
     * PRIVATE FUNCTION TO SAVE USER DATA
     */
    private function save($request, $id = 0) {
        $data = $request->only(['first_name','last_name' ,'user_phone','email','address','gender']);
        $data['is_verified']=1;
        if($id ==0) {
            $data['store_image'] = url('images/default_profile');
        }
//        dd($request->all());
        if ($request->file('user_image')){
            $uploader = new Uploader();
            $uploader->setInputName('user_image');
            if ($uploader->isValidFile()) {
                $uploader->upload('users', $uploader->fileName);
                if ($uploader->isUploaded()) {
                    $data['user_image'] = $uploader->getUploadedPath();
                }
            }
            if (!$uploader->isUploaded()) {
                return redirect()->back()->withErrors('err', $uploader->getMessage())->withInput();
            }
            if ($request->user_id > 0){
                $user = User::find($request->user_id);
                if (!is_null($user->user_image)){
//                dd(env('PUBLIC_BASE_PATH').$user->getOriginal('user_image'));
//                dd(File::delete(env('PUBLIC_BASE_PATH').$user->getOriginal('user_image')));
                    File::delete(env('PUBLIC_BASE_PATH').$user->getOriginal('user_image'));
                }
            }

        }

        if (!empty($request->get('password'))) {
            $data['password'] = bcrypt($request->get('password'));
        }

       User::updateOrCreate(['id' => $id], $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' => ($id > 0) ? 'Edit User' : 'Add User'];
        $user = new User();
        if ($id > 0){
            $user = User::findOrFail($id);
        }

        return view('admin.users.edit', [
            'user' => $user,
            'id'=>$id,
            'action' => route('admin.users.update', $id),
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(AdminUserRequest $request, $id) {
        $this->save($request, $id);
        return redirect(route('admin.users.index'))->with('status', 'User profile updated successfully.');
    }

    public function toggleStatus($id) {
        $user = User::find($id);
        $response = ['msg' => 'Account does not exist.'];
        if (sizeof($user) > 0) {
            if ($user->is_active==1) {
                $user->is_active = 0;
            }
            else {
                $user->is_active = 1;
            }
            $user->save();
            $response['msg'] = 'Account updated.';
        }
        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        User::destroy($id);
        return response(['msg' => 'Account deleted.']);
    }

    public function bulkDelete($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $key=>$value){
            User::destroy($value);
        }
        return response(['msg' => 'Users deleted successfully.']);
    }
    public function restore($id) {
        User::withTrashed()->where('id',$id)->update(['deleted_at'=>NULL]);
        return response(['msg' => 'User restored successfully.']);
    }
    public function bulkRestore($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $key=>$value){
            User::withTrashed()->where('id',$value)->update(['deleted_at'=>NULL]);
        }
        return response(['msg' => 'Users restored successfully.']);
    }

}
