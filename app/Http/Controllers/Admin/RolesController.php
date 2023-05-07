<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\SubModule;
use App\Http\Requests\SaveRole;
use App\Http\Libraries\DataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class RolesController extends Controller {

    public function __construct() {
        parent::__construct('adminData', 'admin');
//        $this->middleware('admin.role:crud', ['only' => ['index']]);
//        $this->middleware('admin.role:crud,0', ['only' => ['all']]);
//        $this->middleware('admin.role:create', ['only' => ['create', 'store']]);
//        $this->middleware('admin.role:read', ['only' => ['show']]);
//        $this->middleware('admin.role:update', ['only' => ['edit', 'update']]);
//        $this->middleware('admin.role:update,0', ['only' => ['toggleStatus']]);
//        $this->middleware('admin.role:delete,0', ['only' => ['destroy']]);
        $this->breadcrumbTitle = 'Roles';
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }

    public function index() {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-users', 'title' => 'Manage Roles'];
        return view('admin.roles.index');
    }

    public function all() {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'title', 'dt' => 'title'],
            ['db' => 'is_active', 'dt' => 'is_active'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
            ['db' => 'deleted_at', 'dt' => 'deleted_at'],
        ];
        DataTable::init(new Role, $columns);

        $title = \request('datatable.query.title','');
        $trashedRole = \request('datatable.query.trashedRole',NULL);
        $activeRoles = \request('datatable.query.activeRoles','');
        $createdAt = \request('datatable.query.createdAt','');
        $updatedAt = \request('datatable.query.updatedAt','');
        $deletedAt = \request('datatable.query.deletedAt','');
//        $sortOrder = \request('datatable.sort.sort');
//        $sortColumn = \request('datatable.sort.field');

        if(!empty($trashedRole)){
            DataTable::getOnlyTrashed();
        }

        if($title != '') {
            DataTable::where('title', 'LIKE', '%'.addslashes($title).'%');
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
            $sWhere = function($query) use ($deletedAt) {
                $deletedAt = Carbon::createFromFormat('m/d/Y', $deletedAt);
                $dBetween = [$deletedAt->hour(0)->minute(0)->second(0)->timestamp, $deletedAt->hour(23)->minute(59)->second(59)->timestamp];
                $query->whereBetween('deleted_at',$dBetween);
            };
            DataTable::getOnlyTrashed($sWhere);
        }

        if($activeRoles != '') {
            DataTable::where('is_active', '=', $activeRoles);
        }

//        if(!empty($sortOrder) && !empty($sortColumn)){
//            DataTable::orderBy($sortColumn ,$sortOrder);
//        }

        DataTable::with('subModules');
        DataTable::where('id', '!=', 1);
        $roles = DataTable::get();
        if (sizeof($roles['data']) > 0) {
            $dateFormat = config('settings.date-format');
            foreach ($roles['data'] as $key => $role) {
                $roles['data'][$key]['modules'] = (sizeof($roles['data'][$key]['subModules']) > 0) ? implode(',', $roles['data'][$key]['subModules']->pluck('title')->all()): '---';
                $roles['data'][$key]['is_active'] = '<a href="javascript:{};" data-url="'.route('admin.roles.toggle-status', ['id' => $role['id']]).'" class="toggle-status-button">';
                $roles['data'][$key]['is_active'] .= (($role['is_active']==1) ? 'Yes':'No').'</a>';
                $roles['data'][$key]['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $role['created_at'])->format($dateFormat);
                $roles['data'][$key]['updated_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $role['updated_at'])->format($dateFormat);
                if(!empty($trashedRole)){
                    $roles['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill restore-record-button" href="javascript:{};" data-url="' . route('admin.roles.restore', ['roles' => $role['id']]) . '" title="Restore Role"><i class="fa fa-fw fa-undo"></i></a>'.
                        '<span class="m-badge m-badge--danger">'.Carbon::createFromFormat('Y-m-d H:i:s', $role['deleted_at'])->format($dateFormat).'</span>';
                }else {
                    $roles['data'][$key]['actions'] = '<a href="' . route('admin.roles.edit', $role['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.roles.destroy', ['roles' => $role['id']]) . '" title="Delete"><i class="la la-trash"></i></a>';
                }
            }
        }
        return response($roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-users', 'title' => 'Add Role'];
        return view('admin.roles.create', [
            'role' => new Role,
            'subModules' => SubModule::with(['module'])->get()->toArray(),
            'action' => route('admin.roles.store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveRole $request) {
        $err = $this->save($request);
        return ($err) ? $err:redirect(route('admin.roles.index'))->with('status', 'Role saved successfully');
    }

    private function save($request, $id = 0) {
        $roleSubModules = json_decode($request->get('role_sub_modules', '[]'), TRUE);
        if (sizeof($roleSubModules) > 0) {
            $subModules = [];
            $rules = [
                'sub_module_id' => 'required|exists:sub_modules,id',
                'mp_create' => 'required|in:0,1',
                'mp_read' => 'required|in:0,1',
                'mp_update' => 'required|in:0,1',
                'mp_delete' => 'required|in:0,1',
            ];
            foreach ($roleSubModules as $key => $role) {
                $subModules[$role['sub_module_id']] = $role;
                $validator = \Validator::make($role, $rules);
                unset($subModules[$role['sub_module_id']]['sub_module_id']);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors(['error' => $validator->messages()->first()])->withInput();
                }
            }
            $role = Role::updateOrCreate(['id' => $id], $request->only(['title', 'description', 'is_active']));
            $role->subModules()->sync($subModules);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $role = Role::with(['subModules'])
            ->where('id', '!=', 1)
            ->findOrFail($id);
        $subModules = [];
        foreach ($role->subModules as $key => $sub) {
            $subModules[$sub->id] = $sub->toArray();
        }
        unset($role->subModules);
        $role->subModules = $subModules;
        return view('admin.roles.edit', [
            'role' => $role,
            'subModules' => SubModule::with(['module'])->get()->toArray(),
            'action' => route('admin.roles.update', ['id' => $id]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveRole $request, $id) {
        $err = $this->save($request, $id);
        return ($err) ? $err:redirect(route('admin.roles.index'))->with('status', 'Role updated successfully');
    }

    public function toggleStatus($id) {
        $role = Role::withTrashed()->find($id);
        $response = ['msg' => 'Role does not exist'];
        if (sizeof($role) > 0) {
            if ($role->is_active==1) {
                $role->is_active = 0;
            }
            else {
                $role->is_active = 1;
            }
            $role->save();
            $response['msg'] = 'Role updated';
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
        Role::destroy($id);
        return response(['msg' => 'Role deleted']);
    }

    public function restore($id) {
        Role::withTrashed()->where('id',$id)->update(['deleted_at'=>NULL]);
        return response(['msg' => 'Role restored successfully.']);
    }

    public function bulkRestore($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $key=>$value){
            Role::withTrashed()->where('id',$value)->update(['deleted_at'=>NULL]);
        }
        return response(['msg' => 'Roles restored successfully.']);
    }

    public function bulkDelete($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $key=>$value){
            Role::destroy($value);
        }
        return response(['msg' => 'Roles deleted successfully.']);
    }

}
