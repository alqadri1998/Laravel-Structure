<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\User;
use App\Traits\Administrators;
use App\Http\Libraries\DataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAdministrator;
use Carbon\Carbon;

class AdministratorsController extends Controller
{

    use Administrators;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
//        $this->middleware('admin.role:crud', ['only' => ['index']]);
//        $this->middleware('admin.role:crud,0', ['only' => ['all']]);
//        $this->middleware('admin.role:create', ['only' => ['create', 'store']]);
//        $this->middleware('admin.role:read', ['only' => ['show']]);
//        $this->middleware('admin.role:update', ['only' => ['edit', 'update']]);
//        $this->middleware('admin.role:update,0', ['only' => ['toggleStatus']]);
//        $this->middleware('admin.role:delete,0', ['only' => ['destroy']]);
        $this->breadcrumbTitle = 'Customers';
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('hello');

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' => 'Manage Customers'];
        return view('admin.administrators.index');
    }

    public function all()
    {

        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'first_name', 'dt' => 'full_name'],
            ['db' => 'email', 'dt' => 'email'],
            ['db' => 'address', 'dt' => 'address'],
            ['db' => 'is_active', 'dt' => 'is_active'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
            ['db' => 'deleted_at', 'dt' => 'deleted_at'],
        ];

        DataTable::init(new User, $columns);
        DataTable::where('id', '!=', $this->user['id']);
        DataTable::where('id', '!=', Admin::superSystemAdminId);
        $fullName = \request('datatable.query.full_name', '');
        $email = \request('datatable.query.email', '');
        $trashedAdmins = \request('datatable.query.trashedAdmins', NULL);
        $activeAdmins = \request('datatable.query.activeAdmins', '');
        $createdAt = \request('datatable.query.createdAt', '');
        $updatedAt = \request('datatable.query.updatedAt', '');
        $deletedAt = \request('datatable.query.deletedAt', '');


        if (!empty($trashedAdmins)) {
            DataTable::getOnlyTrashed();
        }

        if ($createdAt != '') {
            $createdAt = Carbon::createFromFormat('m/d/Y', $createdAt);
            $cBetween = [$createdAt->hour(0)->minute(0)->second(0)->timestamp, $createdAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('created_at', $cBetween);
        }
        if ($updatedAt != '') {
            $updatedAt = Carbon::createFromFormat('m/d/Y', $updatedAt);
            $uBetween = [$updatedAt->hour(0)->minute(0)->second(0)->timestamp, $updatedAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('updated_at', $uBetween);
        }
        if (!empty($deletedAt)) {
            $sWhere = function ($query) use ($deletedAt) {
                $deletedAt = Carbon::createFromFormat('m/d/Y', $deletedAt);
                $dBetween = [$deletedAt->hour(0)->minute(0)->second(0)->timestamp, $deletedAt->hour(23)->minute(59)->second(59)->timestamp];
                $query->whereBetween('deleted_at', $dBetween);
            };
            DataTable::getOnlyTrashed($sWhere);
        }

        if ($fullName != '') {

            DataTable::where('full_name', 'LIKE', '%' . addslashes($fullName) . '%');

        }


        if ($email != '') {
            DataTable::where('email', 'like', '%' . addslashes($email) . '%');
        }

        if ($activeAdmins != '') {
            DataTable::where('is_active', '=', $activeAdmins);
        }

        if (!empty($sortOrder) && !empty($sortColumn)) {
            DataTable::orderBy($sortColumn, $sortOrder);
        }

        $administrators = DataTable::get();
        if (sizeof($administrators['data']) > 0) {
            $dateFormat = config('settings.date-format');
            foreach ($administrators['data'] as $key => $admin) {


                $administrators['data'][$key]['role_id'] = $admin['role']->title;
                $administrators['data'][$key]['is_active'] = '<a href="javascript:{};" data-url="' . route('admin.administrators.toggle-status', ['id' => $admin['id']]) . '" class="toggle-status-button">';
                $administrators['data'][$key]['is_active'] .= (($admin['is_active'] == 1) ? 'Yes' : 'No') . '</a>';

                $administrators['data'][$key]['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $admin['created_at'], config('settings.timezone'))->format($dateFormat);
                $administrators['data'][$key]['updated_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $admin['updated_at'], config('settings.timezone'))->format($dateFormat);

                if (!empty($trashedAdmins)) {

                    $administrators['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill restore-record-button" href="javascript:{};" data-url="' . route('admin.administrators.restore', ['administrators' => $admin['id']]) . '" title="Restore Admin"><i class="fa fa-fw fa-undo"></i></a>';
//                        '<span class="m-badge m-badge--danger">'.Carbon::createFromFormat('Y-m-d H:i:s', $admin['deleted_at'])->format($dateFormat).'</span>';
                } else {
                    $administrators['data'][$key]['actions'] = '<a href="' . route('admin.administrators.edit', ['administrators' => $admin['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.administrators.destroy', ['administrators' => $admin['id']]) . '" title="Delete"><i class="la la-trash"></i></a>';
                }


                unset($administrators['data'][$key]['role']);

            }
        }


        return response($administrators);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Admin::getAllRoles();
        $roles = array_prepend($roles, 'Select Role', '');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' => 'Add Customer'];
        return view('admin.administrators.create', [
            'admin' => new Admin(),
            'roles' => $roles,
            'action' => route('admin.administrators.store'),
            'languageId' => 2
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveAdministrator $request)
    {
        $err = $this->save($request);
        return ($err) ? $err : redirect(route('admin.administrators.index'))->with('status', 'New Customer added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        $roles = Admin::getAllRoles();
        $roles = array_prepend($roles, 'Select Role', '');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' => 'Edit Customer'];
        return view('admin.administrators.edit', [
            'admin' => $admin,
            'roles' => $roles,
            'action' => route('admin.administrators.update', ['administrators' => $id])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveAdministrator $request, $id)
    {
        $err = $this->save($request, $id);
        return ($err) ? $err : redirect(route('admin.administrators.index'))->with('status', 'Account updated successfully');
    }

    public function toggleStatus($id)
    {
        $admin = Admin::withTrashed()->find($id);
        $response = ['msg' => 'Account does not exist'];
        if (sizeof($admin) > 0) {
            if ($admin->is_active == 1) {
                $admin->is_active = 0;
                $response['msg'] = 'User account is deactivated';

            } else {
                $admin->is_active = 1;
                $response['msg'] = 'User account is activated';
            }
            $admin->save();

        }
        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        return response(['msg' => 'Account deleted']);
    }

    public function restore($id)
    {
        Admin::withTrashed()->where('id', $id)->update(['deleted_at' => NULL]);
        return response(['msg' => 'Customer restored successfully.']);
    }

    public function bulkDelete($ids)
    {
        $ids = explode(',', $ids);
        foreach ($ids as $key => $value) {
            Admin::destroy($value);
        }
        return response(['msg' => 'Customer deleted successfully.']);
    }

    public function bulkRestore($ids)
    {
        $ids = explode(',', $ids);
        foreach ($ids as $key => $value) {
            Admin::withTrashed()->where('id', $value)->update(['deleted_at' => NULL]);
        }
        return response(['msg' => 'Customer restored successfully.']);
    }

}
