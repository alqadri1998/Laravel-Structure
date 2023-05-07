<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FromValidation;
use App\Models\Category;
use App\Traits\GetAttributes;
use Illuminate\Support\Arr;
use App\Http\Libraries\DataTable;
use Carbon\Carbon;

class CategoryController extends Controller
{
    use GetAttributes;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');

        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->breadcrumbTitle = 'Vehicles';
    }

    public function index()
    {
//        dd('CategoryController@index');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Vehicles'];

        $categories = Category::whereHas('languages')->with(['languages', 'subCategories' => function ($subCategories) {
            $subCategories->whereHas('languages')->with(['languages', 'subCategories' => function ($query) {
                $query->whereHas('languages')->with('languages');
            }]);
        }])->where('parent_id', 0)->orderBy('created_at', 'DESC')->get();
        $this->setTranslations($categories, 'languages', ['subCategories' => 'languages']);

        unset($categories->languages);
        foreach ($categories as $key => $value) {
            foreach ($value->subCategories as $modelKey => $model) {
                if (count($model->subCategories) > 0) {
                    $this->setTranslations($model->subCategories);
                    unset($model->subCategories->languages);
                }

            }

        }
        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function all()
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
        DataTable::where('parent_id', '=', 0);
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
                    $category['data'][$key]['actions'] = '<a href="' . route('admin.category.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $category['data'][$key]['actions'] = '<a href="' . route('admin.category.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a href="' . route('admin.categories.sub-categories.index', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="sub category"><i class="fa fa-fw fa-eye"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.categories.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($category);
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Vehicle' : 'Add Vehicle');
        $this->breadcrumbs[route('admin.category.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Vehicles'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        $category = $this->getViewParams($id);
        return view('admin.categories.edit', [
            'categoryId' => $id,
            'category' => $category,
            'action' => route('admin.category.save', $id),
            'categoryData' => $this->getCategories(),
            'selectedAttributes' => $category->attributes()->pluck('id')->toArray(),
            'attributesData' => arr::except($this->getAttributes(), 0)
        ]);

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
            $category = Category::with('languages', 'attributes')->findOrFail($id);
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

    public function save(FromValidation $request, $id)
    {
        $data = $request->only('parent_id');
        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
        }
        $category = Category::updateOrCreate(['id' => $id], $data);
        $category->languages()->syncWithoutDetaching([$request->language_id => [
            'name' => $request->name
        ]]);
        $category->attributes()->sync($request->attribute_id);
        return redirect(route('admin.category.index'))->with('status', 'Vehicle  added successfully');
    }

    public function destroy($id)
    {
        $category = Category::where('id', '=', $id)->firstOrFail();
        Category::where('parent_id', '=', $category->id)->delete();
        $category->languages()->detach();
        $category->attributes()->detach();
        $category::destroy($id);
        return response(['msg' => 'Vehicle deleted successfully.']);
    }

}
