<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreBranchRequest;
use App\Models\Branch;
use App\Http\Libraries\DataTable;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    public function __construct()
    {
        parent::__construct('adminData', 'admin');

        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->breadcrumbTitle = 'Branches';

    }

    public function index()
    {

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Branches'];
        return view('admin.branches.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'address', 'dt' => 'address'],
            ['db' => 'timings', 'dt' => 'timings'],
            ['db' => 'phone', 'dt' => 'phone'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        DataTable::init(new Branch(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        $dateFormat = config('settings.date-format');
        $branch = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($branch['data']) > 0) {
            foreach ($branch['data'] as $key => $data) {
                $count = $count + 1;
                $branch['data'][$key]['id'] = $count + $perPage;
                $branch['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $branch['data'][$key]['title'] = '';
                if (count($data['languages']) > 0) {
                    $branch['data'][$key]['title'] = $data['languages'][0]->pivot->title;
                }
                unset($branch['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $branch['data'][$key]['actions'] = '<a href="' . route('admin.branches.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $branch['data'][$key]['actions'] = '<a href="' . route('admin.branches.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.branches.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($branch);
    }

    public function store(StoreBranchRequest $request, $id)
    {
//        dd($request->all());
        $data = $request->only('address', 'timings', 'phone', 'latitude', 'longitude', 'image', 'whatsapp_phone');

        $data = $this->manageTimings($request, $data);

        $data['slug'] = str_slug($request->title);
        if ($id == 0 && Branch::whereSlug($data['slug'])->exists()) {

            return redirect()->back()->with('err', __('Branch with same name already exists.'));
        }
        $branch = Branch::updateOrCreate(['id' => $id], $data);
        $branch->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
        ]]);
        if ($id == 0){
            return redirect(route('admin.branches.index'))->with('status', 'Branch added successfully');
        }else{
            return redirect(route('admin.branches.index'))->with('status', 'Branch updated successfully');
        }
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Branch' : 'Add Branch');
        $this->breadcrumbs[route('admin.branches.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Branches'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];

        return view('admin.branches.edit', [
            'branch' => $this->getViewParams($id),
            'action' => route('admin.branches.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $branch = Branch::where('id', '=', $id)->firstOrFail();
        $branch->languages()->detach();
        $branch::destroy($id);
        return response(['msg' => 'Branch deleted successfully.']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $branch = new Branch();
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
        }
        if ($id > 0) {
            $branch = Branch::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($branch->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                    }
                }
            }
            unset($branch->languages);
        }
        $branch['translations'] = $translations;
        return $branch;
    }

    public function manageTimings($request, $data){
        if ($request->has('mondayIsOn')) {
            $day = new \stdClass();
            $day->start_time = $request->monday_start_time;
            $day->end_time = $request->monday_end_time;
            $data['monday'] = json_encode($day);
        } else {
            $data['monday'] = null;
        }

        if ($request->has('tuesdayIsOn')) {
            $day = new \stdClass();
            $day->start_time = $request->tuesday_start_time;
            $day->end_time = $request->tuesday_end_time;
            $data['tuesday'] = json_encode($day);
        } else {
            $data['tuesday'] = null;
        }

        if ($request->has('wednesdayIsOn')) {
            $day = new \stdClass();
            $day->start_time = $request->wednesday_start_time;
            $day->end_time = $request->wednesday_end_time;
            $data['wednesday'] = json_encode($day);
        } else {
            $data['wednesday'] = null;
        }

        if ($request->has('thursdayIsOn')) {
            $day = [];
            $day['start_time'] = $request->thursday_start_time;
            $day['end_time'] = $request->thursday_end_time;
            $data['thursday'] = json_encode($day);
        } else {
            $data['thursday'] = null;
        }

        if ($request->has('fridayIsOn')) {
            $day = [];
            $day['start_time'] = $request->friday_start_time;
            $day['end_time'] = $request->friday_end_time;
            $data['friday'] = json_encode($day);
        } else {
            $data['friday'] = null;
        }

        if ($request->has('saturdayIsOn')) {
            $day = [];
            $day['start_time'] = $request->saturday_start_time;
            $day['end_time'] = $request->saturday_end_time;
            $data['saturday'] = json_encode($day);
        } else {
            $data['saturday'] = null;
        }

        if ($request->has('sundayIsOn')) {
            $day = [];
            $day['start_time'] = $request->sunday_start_time;
            $day['end_time'] = $request->sunday_end_time;
            $data['sunday'] = json_encode($day);
        } else {
            $data['sunday'] = null;
        }

        return $data;

    }

}
