<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\DataTable;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->breadcrumbTitle = 'Services';

    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Services'];
        return view('admin.services.index');
    }

    public function all()
    {
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'slug', 'dt' => 'slug'],
            ['db' => 'type', 'dt' => 'type'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        DataTable::init(new Service(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        $dateFormat = config('settings.date-format');
        $service = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($service['data']) > 0) {
            foreach ($service['data'] as $key => $data) {
                $count = $count + 1;
                $service['data'][$key]['id'] = $count + $perPage;
                $service['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $service['data'][$key]['title'] = '';
                $service['data'][$key]['description'] = '';
                if (count($data['languages']) > 0) {
                    $service['data'][$key]['title'] = $data['languages'][0]->pivot->title;
                    $service['data'][$key]['description'] = $data['languages'][0]->pivot->description;
                }
                unset($service['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $service['data'][$key]['actions'] = '<a href="' . route('admin.services.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $service['data'][$key]['actions'] = '<a href="' . route('admin.services.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.services.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($service);
    }

    public function store(StoreServiceRequest $request, $id)
    {

        $data['slug'] = str_slug($request->title);
        $data['type'] = $request->type;
        if ($id == 0 && Service::whereSlug($data['slug'])->exists()) {

            return redirect()->back()->with('err', 'Service with same name already exists.');
        }

        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
            if ($id > 0){
                $service = Service::findOrFail($id);
                File::delete(env('PUBLIC_BASE_PATH').$service->getOriginal('image'));
            }
        }
        if ($request->has('icon') && $request->icon != '') {
            $data['icon'] = $request->get('icon');
            if ($id > 0){
                $service = Service::findOrFail($id);
                File::delete(env('PUBLIC_BASE_PATH').$service->getOriginal('icon'));
            }
        }

        $service = Service::updateOrCreate(['id' => $id], $data);
        $service->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
            'description' => $request->description
        ]]);
        return redirect(route('admin.services.index'))->with('status', 'Service  added successfully.');
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Service' : 'Add Service');
        $this->breadcrumbs[route('admin.services.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Services'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.services.edit', [
            'service' => $this->getViewParams($id),
            'action' => route('admin.services.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $service = Service::where('id', '=', $id)->firstOrFail();
        if (!is_null($service->image)){
            File::delete(env('PUBLIC_BASE_PATH').$service->getOriginal('image'));
        }
        if (!is_null($service->icon)){
            File::delete(env('PUBLIC_BASE_PATH').$service->getOriginal('icon'));
        }
        $service->languages()->detach();
        $service::destroy($id);
        return response(['msg' => 'Service Deleted']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $service = new Service();
        $service->start_date = Carbon::now()->timestamp;
        $service->end_date = Carbon::now()->timestamp;
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
            $translations[$languageId]['description'] = '';
        }
        if ($id > 0) {
            $service = Service::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($service->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                        $translations[$languageId]['description'] = $language->pivot->description;
                    }
                }
            }
            unset($service->languages);
        }
        $service['translations'] = $translations;
        return $service;
    }
}
