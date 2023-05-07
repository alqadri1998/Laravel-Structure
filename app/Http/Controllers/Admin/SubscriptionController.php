<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\DataTable;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public $subscription;
    public $editRoute = 'admin.brands.edit';
    public $deleteRoute = 'admin.brands.destroy';

    public function __construct(Subscription $subscription)
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->subscription = $subscription;
        $this->breadcrumbTitle = 'Subscriptions';
    }

    public function index()
    {

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Subscriptions'];
        return view('admin.subscriptions.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'email', 'dt' => 'email'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],

        ];
        DataTable::init(new Subscription(), $columns);
        $dateFormat = config('settings.date-format');
        $brand = DataTable::get();
//        dd($brand);
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($brand['data']) > 0) {
            foreach ($brand['data'] as $key => $data) {
                $count = $count + 1;
                $brand['data'][$key]['id'] = $count + $perPage;
                $brand['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $brand['data'][$key]['count'] = $count + $perPage;

                /*if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $brand['data'][$key]['actions'] = '<a href="' . route('admin.subscriptions.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $brand['data'][$key]['actions'] = '<a href="' . route('admin.subscriptions.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.subscriptions.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }*/
            }
        }
        return response($brand);
    }

    public function store(StoreBrandRequest $request, $id)
    {
        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
        }
        $data['slug'] = str_slug($request->title);
        if ($id == 0 && Brand::whereSlug($data['slug'])->exists()) {

            return redirect()->back()->with('err', __('Brand With Same Name Already Exist'));
        }
        $brand = Brand::updateOrCreate(['id' => $id], $data);
        $brand->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
        ]]);
        return redirect(route('admin.brands.index'))->with('status', 'Brand  Added');
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Brand' : 'Add Brand');
        $this->breadcrumbs[route('admin.brands.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Brands'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.brands.edit', [
            'brand' => $this->getViewParams($id),
            'action' => route('admin.brands.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $brand = Brand::where('id', '=', $id)->firstOrFail();
        $brand->languages()->detach();
        $brand::destroy($id);
        return response(['msg' => 'Brand Deleted']);
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
