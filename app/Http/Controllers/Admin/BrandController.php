<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\DataTable;
use App\Http\Requests\StoreBrandRequest;
use App\Models\Brand;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public $brand;
    public $editRoute = 'admin.brands.edit';
    public $deleteRoute = 'admin.brands.destroy';

    public function __construct(Brand $brand)
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->brand = $brand;
        $this->breadcrumbTitle = 'Brands';
    }

    public function index()
    {

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Brands'];
        return view('admin.brands.index');
    }

    public function all()
    {
        //        $languageKeys =['title'];
//        $brands = $this->initDataTable($this->brand, $columns, $languageKeys, $this->editRoute, $this->deleteRoute);
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'image', 'dt' => 'image'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],

        ];
        DataTable::init(new Brand(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        $dateFormat = config('settings.date-format');
        $brand = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($brand['data']) > 0) {
            foreach ($brand['data'] as $key => $data) {
                $count = $count + 1;
                $brand['data'][$key]['id'] = $count + $perPage;
                $brand['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $brand['data'][$key]['title'] = '';
                if (count($data['languages']) > 0) {
                    $brand['data'][$key]['title'] = $data['languages'][0]->pivot->title;
                }
                unset($brand['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $brand['data'][$key]['actions'] = '<a href="' . route('admin.brands.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $brand['data'][$key]['actions'] = '<a href="' . route('admin.brands.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.brands.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($brand);
    }

    public function store(StoreBrandRequest $request, $id)
    {
        $data['slug'] = str_slug($request->title);
        if ($id == 0 && Brand::whereSlug($data['slug'])->exists()) {

            return redirect()->back()->with('err', __('Brand with same name already exists.'));
        }

        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
            if ($id > 0){
                $brand = Brand::findOrFail($id);
                File::delete(env('PUBLIC_BASE_PATH').$brand->getOriginal('image'));
            }
        }
        $brand = Brand::updateOrCreate(['id' => $id], $data);
        $brand->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
        ]]);
        return redirect(route('admin.brands.index'))->with('status', 'Brand added successfully.');
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Brand' : 'Add Brand');
        $this->breadcrumbs[route('admin.brands.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Brands'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
//        dd($this->getViewParams($id));
        return view('admin.brands.edit', [
            'brand' => $this->getViewParams($id),
            'action' => route('admin.brands.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $brand = Brand::where('id', '=', $id)->firstOrFail();
        $brand->languages()->detach();
        if (!is_null($brand->image)){
            File::delete(env('PUBLIC_BASE_PATH').$brand->getOriginal('image'));
        }
        $brand::destroy($id);
        return response(['msg' => 'Brand deleted successfully.']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $brand = new Brand();
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
        }
        if ($id > 0) {
            $brand = Brand::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($brand->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                    }
                }
            }
            unset($brand->languages);
        }
        $brand['translations'] = $translations;
        return $brand;
    }

}
