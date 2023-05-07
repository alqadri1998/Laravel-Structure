<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\DataTable;
use App\Http\Requests\StorePromotionRequest;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PromotionController extends Controller
{
    public $promotion;
    public $editRoute = 'admin.promotions.edit';
    public $deleteRoute = 'admin.promotions.destroy';

    public function __construct(Promotion $promotion)
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->promotion = $promotion;
        $this->breadcrumbTitle = 'Promotions';

    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Promotions'];
        return view('admin.promotions.index');
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
        DataTable::init(new Promotion(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        $dateFormat = config('settings.date-format');
        $promotion = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($promotion['data']) > 0) {
            foreach ($promotion['data'] as $key => $data) {
                $count = $count + 1;
                $promotion['data'][$key]['id'] = $count + $perPage;
                $promotion['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $promotion['data'][$key]['title'] = '';
                if (count($data['languages']) > 0) {
                    $promotion['data'][$key]['title'] = $data['languages'][0]->pivot->title;
                }
                unset($promotion['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $promotion['data'][$key]['actions'] = '<a href="' . route('admin.promotions.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $promotion['data'][$key]['actions'] = '<a href="' . route('admin.promotions.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.promotions.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($promotion);
    }

    public function store(StorePromotionRequest $request, $id)
    {
        $data['slug'] = str_slug($request->title);
        if ($id == 0 && Promotion::whereSlug($data['slug'])->exists()) {

            return redirect()->back()->with('err', __('Promotion with same name already exists.'));
        }

        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
            if ($id > 0){
                $promotion = Promotion::findOrFail($id);
                File::delete(env('PUBLIC_BASE_PATH').$promotion->getOriginal('image'));
            }
        }

        $promotion = Promotion::updateOrCreate(['id' => $id], $data);
        $promotion->languages()->syncWithoutDetaching([$request->language_id => [
            'title' => $request->title,
        ]]);
        return redirect(route('admin.promotions.index'))->with('status', 'Promotion  added successfully.');
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Promotion' : 'Add Promotion');
        $this->breadcrumbs[route('admin.promotions.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Promotion'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.promotions.edit', [
            'promotion' => $this->getViewParams($id),
            'action' => route('admin.promotions.store', $id)
        ]);
    }

    public function destroy($id)
    {
        $promotion = Promotion::where('id', '=', $id)->firstOrFail();
        if (!is_null($promotion->image)){
            File::delete(env('PUBLIC_BASE_PATH').$promotion->getOriginal('image'));
        }
        $promotion->languages()->detach();
        $promotion::destroy($id);
        return response(['msg' => 'Promotion deleted successfully.']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $promotion = new Promotion();
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
        }
        if ($id > 0) {
            $promotion = Promotion::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($promotion->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                    }
                }
            }
            unset($promotion->languages);
        }
        $promotion['translations'] = $translations;
        return $promotion;
    }
}
