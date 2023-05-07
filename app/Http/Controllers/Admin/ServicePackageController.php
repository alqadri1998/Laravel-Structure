<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\DataTable;
use App\Http\Requests\StoreServicePackageRequest;
use App\Models\Product;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ServicePackageController extends Controller
{
    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->breadcrumbTitle = 'Service Packages';

    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Service Packages'];
        return view('admin.service-packages.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'price', 'dt' => 'price'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        DataTable::init(new Product(), $columns);
        DataTable::with('languages');
//        DataTable::whereHas('languages');
        DataTable::where('type', '=', 'package');
        $dateFormat = config('settings.date-format');
        $servicePackage = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($servicePackage['data']) > 0) {
            foreach ($servicePackage['data'] as $key => $data) {
                $count = $count + 1;
                $servicePackage['data'][$key]['id'] = $count + $perPage;
                $servicePackage['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $servicePackage['data'][$key]['title'] = '';
                $servicePackage['data'][$key]['short_description'] = '';

                if (count($data['languages']) > 0) {
                    foreach ($data['languages'] as $language)
                    {
                        if ($language->id == 2){
                            $servicePackage['data'][$key]['title'] = $language->pivot->title;
                            $servicePackage['data'][$key]['short_description'] = $language->pivot->short_description;
                        }
                    }
                }
                unset($servicePackage['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $servicePackage['data'][$key]['actions'] = '<a href="' . route('admin.packages.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $servicePackage['data'][$key]['actions'] = '<a href="' . route('admin.packages.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.packages.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($servicePackage);
    }

    public function store(StoreServicePackageRequest $request, $id)
    {
//        dd($request->all());
        $data = $request->only('price', 'quantity');
        $data['slug'] = str_slug($request->title);
        $data['type'] = 'package';
        if ($id == 0 && Product::whereSlug($data['slug'])->exists() && Product::where('slug', $data['slug'])->first()->type == 'package') {
            return redirect()->back()->with('err', __('Service package with same name already exists.'));
        }

        if($id == 0 && Product::whereSlug($data['slug'])->exists()){
            $data['slug'] = str_slug($request->title).str::random();
        }

        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
            if ($id > 0){
                $product = Product::findOrFail($id);
                File::delete(env('PUBLIC_BASE_PATH').$product->getOriginal('image'));
            }
        }
        $servicePackage = Product::updateOrCreate(['id' => $id], $data);
        $servicePackage->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
        ]]);
        return redirect(route('admin.packages.index'))->with('status', 'Service package added successfully.');
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Service Package' : 'Add Service Package');
        $this->breadcrumbs[route('admin.packages.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Service Packages'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.service-packages.edit', [
            'servicePackage' => $this->getViewParams($id),
            'action' => route('admin.packages.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $servicePackage = Product::where('id', '=', $id)->firstOrFail();
        $servicePackage->languages()->detach();
        $servicePackage::destroy($id);
        return response(['msg' => 'Service package deleted successfully.']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $servicePackage = new Product();
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
            $translations[$languageId]['long_description'] = '';
            $translations[$languageId]['short_description'] = '';
        }
        if ($id > 0) {
            $servicePackage = Product::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($servicePackage->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                        $translations[$languageId]['short_description'] = $language->pivot->short_description;
                        $translations[$languageId]['long_description'] = $language->pivot->long_description;
                    }
                }
            }
            unset($servicePackage->languages);
        }
        $servicePackage['translations'] = $translations;
        return $servicePackage;
    }
}
