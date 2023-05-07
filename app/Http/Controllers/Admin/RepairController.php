<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\DataTable;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Repair;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class RepairController extends Controller
{
    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Repairs'];
        return view('admin.repairs.index');
    }

    public function all()
    {
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
//            ['db' => 'icon', 'dt' => 'icon'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        DataTable::init(new Repair(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        $dateFormat = config('settings.date-format');
        $repair = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($repair['data']) > 0) {
            foreach ($repair['data'] as $key => $data) {
                $count = $count + 1;
                $repair['data'][$key]['id'] = $count + $perPage;
                $repair['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $repair['data'][$key]['title'] = '';
                $repair['data'][$key]['description'] = '';
                if (count($data['languages']) > 0) {
                    $repair['data'][$key]['title'] = $data['languages'][0]->pivot->title;
                    $repair['data'][$key]['description'] = $data['languages'][0]->pivot->description;
                }
                unset($repair['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $repair['data'][$key]['actions'] = '<a href="' . route('admin.repairs.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $repair['data'][$key]['actions'] = '<a href="' . route('admin.repairs.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.repairs.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($repair);
    }

    public function store(StoreServiceRequest $request, $id)
    {
        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
        }
        if ($request->has('icon') && $request->icon != '') {
            $data['icon'] = $request->get('icon');
        }
        $data['slug'] = str_slug($request->title);
        if ($id == 0 && Repair::whereSlug($data['slug'])->exists()) {

            return redirect()->back()->with('err', 'Repair With Same Name Already Exist');
        }
        $repair = Repair::updateOrCreate(['id' => $id], $data);
        $repair->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
            'description' => $request->description
        ]]);
        return redirect(route('admin.repairs.index'))->with('status', 'Repair  Added');
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Repair' : 'Add Repair');
        $this->breadcrumbs[route('admin.repairs.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Repairs'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.repairs.edit', [
            'repair' => $this->getViewParams($id),
            'action' => route('admin.repairs.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $repair = Repair::where('id', '=', $id)->firstOrFail();
        $repair->languages()->detach();
        $repair::destroy($id);
        return response(['msg' => 'Repair Deleted']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $repair = new Repair();
        $repair->start_date = Carbon::now()->timestamp;
        $repair->end_date = Carbon::now()->timestamp;
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
            $translations[$languageId]['description'] = '';
        }
        if ($id > 0) {
            $repair = Repair::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($repair->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                        $translations[$languageId]['description'] = $language->pivot->description;
                    }
                }
            }
            unset($repair->languages);
        }
        $repair['translations'] = $translations;
        return $repair;
    }
}
