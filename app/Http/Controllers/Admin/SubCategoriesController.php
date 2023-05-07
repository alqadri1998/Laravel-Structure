<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Libraries\DataTable;
use App\Http\Requests\FromValidation;
use App\Models\Category;
use App\Traits\GetAttributes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    use GetAttributes;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');

        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index($id)
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Models'];
        return redirect(route('admin.category.index'));
//        return view('admin.sub-categories.subCategory', ['id' => $id]);
    }

    public function save(Request $request, $id)
    {
        $data = $request->only('parent_id', 'image');

        $category = Category::updateOrCreate(['id' => $id], $data);
        $category->languages()->syncWithoutDetaching([$request->language_id => [
            'name' => $request->name
        ]]);
        return redirect(route('admin.category.index'))->with('status', 'Model Added');
    }

    public function show($id)
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Models'];
        return view('admin.sub-categories.subCategory', ['id' => $id]);
    }

    public function edit($parentId, $id)
    {
        $heading = (($id > 0) ? 'Edit Model' : 'Add Model');
        $this->breadcrumbs[route('admin.category.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Models'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.sub-categories.edit', [
            'categoryId' => $id,
            'category' => $this->getViewParams($id),
            'action' => route('admin.categories.sub-categories.update', [$parentId, $id]),
            'parent' => $parentId
        ]);
    }

    public function update(FromValidation $request, $parentId, $id)
    {
        $err = $this->save($request, $id);
        if ($id == 0) {
            return ($err) ? $err : redirect(route('admin.category.index'))->with('status', 'Model Added ');
        } else {
            return ($err) ? $err : redirect(route('admin.category.index'))->with('status', 'Model Updated');

        }
    }

    public function all($id)
    {
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'parent_id', 'dt' => 'parent_id'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        DataTable::init(new Category(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        DataTable::where('parent_id', '=', $id);
        $dateFormat = config('settings.date-format');
        $category = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * 10) - $perPage;
        if (sizeof($category['data']) > 0) {

            foreach ($category['data'] as $key => $data) {
                $count = $count + 1;
                $category['data'][$key]['id'] = $count + $perPage;
                $category['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                $category['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $category['data'][$key]['name'] = '';
                if (count($data['languages']) > 0) {
                    $category['data'][$key]['name'] = $data['languages'][0]->pivot->name;
                }
                unset($category['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $category['data'][$key]['actions'] = '<a href="' . route('admin.categories.sub-categories.edit', [$id, $data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $category['data'][$key]['actions'] = '<a href="' . route('admin.categories.sub-categories.edit', [$id, $data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.categories.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($category);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $category = new Category();
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['name'] = '';
        }
        if ($id > 0) {
            $category = Category::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($category->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['name'] = $language->pivot->name;
                    }
                }
            }
            unset($category->languages);
        }
        $category['translations'] = $translations;
        return $category;
    }
}
