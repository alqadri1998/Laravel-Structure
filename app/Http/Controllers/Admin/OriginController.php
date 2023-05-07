<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\DataTable;
use App\Http\Requests\StoreOriginRequest;
use App\Models\Origin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class OriginController extends Controller
{
    public $origin;
    public $editRoute = 'admin.origins.edit';
    public $deleteRoute = 'admin.origins.destroy';

    public function __construct(Origin $origin)
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->origin = $origin;
        $this->breadcrumbTitle = 'Origin';

    }

    public function index()
    {

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Origins'];
        return view('admin.origins.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
//            ['db' => 'image', 'dt' => 'image'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],

        ];
        DataTable::init(new Origin(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        $dateFormat = config('settings.date-format');
        $origin = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($origin['data']) > 0) {
            foreach ($origin['data'] as $key => $data) {
                $count = $count + 1;
                $origin['data'][$key]['id'] = $count + $perPage;
                $origin['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $origin['data'][$key]['title'] = '';
                if (count($data['languages']) > 0) {
                    $origin['data'][$key]['title'] = $data['languages'][0]->pivot->title;
                }
                unset($origin['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $origin['data'][$key]['actions'] = '<a href="' . route('admin.origins.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $origin['data'][$key]['actions'] = '<a href="' . route('admin.origins.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.origins.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($origin);
    }

    public function store(StoreOriginRequest $request, $id)
    {
        $data = $request->only('image');
        $data['slug'] = str_slug($request->title);
        if ($id == 0 && Origin::whereSlug($data['slug'])->exists()) {
            return redirect()->back()->with('err', __('Origin with same name already exists.'));
        }
        $origin = Origin::updateOrCreate(['id' => $id], $data);
        $origin->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
        ]]);
        return redirect(route('admin.origins.index'))->with('status', 'Origin added successfully.');
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Origin' : 'Add Origin');
        $this->breadcrumbs[route('admin.origins.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Origins'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.origins.edit', [
            'origin' => $this->getViewParams($id),
            'action' => route('admin.origins.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $origin = Origin::where('id', '=', $id)->firstOrFail();
        $origin->languages()->detach();
        $origin::destroy($id);
        return response(['msg' => 'Origin deleted successfully.']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $origin = new Origin();
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
        }
        if ($id > 0) {
            $origin = Origin::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($origin->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                    }
                }
            }
            unset($origin->languages);
        }
        $origin['translations'] = $translations;
        return $origin;
    }
}
