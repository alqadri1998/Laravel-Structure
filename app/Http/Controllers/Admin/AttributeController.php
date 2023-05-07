<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Libraries\DataTable;
use App\Http\Requests\FromValidation;
use App\Models\Attribute;
use App\Traits\GetAttributes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    use GetAttributes;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Attributes'];
        $attributes = Attribute::whereHas('languages')->with(['languages', 'subAttributes' => function ($subAttributes) {
            $subAttributes->whereHas('languages')->with('languages');
        }])->where('parent_id', 0)->orderBy('created_at', 'DESC')->get();
        $this->setTranslations($attributes, 'languages', ['subAttributes' => 'languages']);

        unset($attributes->languages);
        return view('admin.attributes.index', ['attributes' => $attributes]);
    }

    public function all()
    {
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
            ['db' => 'parent_id', 'dt' => 'parent_id'],
        ];
        DataTable::init(new Attribute(), $columns);
        $languages = function ($language) {
            $language->withPivot('name');
        };
        DataTable::with('languages', $languages);
        DataTable::whereHas('languages');
        $dateFormat = config('settings.date-format');
        $attribute = DataTable::get(['parent_id' => 0]);
        $count = 0;
        if (sizeof($attribute['data']) > 0) {
            foreach ($attribute['data'] as $key => $data) {
                $count = $count + 1;
                $attribute['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                $attribute['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $attribute['data'][$key]['name'] = '';
                $attribute['data'][$key]['id'] = $count;
                if (count($data['languages']) > 0) {
                    $attribute['data'][$key]['name'] = $data['languages'][0]->pivot->name;
                }
                unset($attribute['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $attribute['data'][$key]['actions'] = '<a href="' . route('admin.attributes.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $attribute['data'][$key]['actions'] = '<a href="' . route('admin.attributes.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a href="' . route('admin.attributes.sub-attributes.index', [$data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="sub Attributes"><i class="fa fa-fw fa-eye"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.attributes.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($attribute);

    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Attribute' : 'Add Attribute');
        $this->breadcrumbs[route('admin.products.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Attributes'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.attributes.edit', [
            'method' => 'PUT',
            'attributeId' => $id,
            'attribute' => $this->getViewParams($id),
            'action' => route('admin.attributes.update', $id)
        ]);
    }

    public function update(FromValidation $request, $id)
    {
        $err = $this->save($request, $id);
        if ($id == 0) {
            return ($err) ? $err : redirect(route('admin.attributes.index'))->with('status', 'Attribute Added ');
        } else {
            return ($err) ? $err : redirect(route('admin.attributes.index'))->with('status', 'Attributes Updated');

        }
    }

    public function save($request, $id)
    {
//        dd($request->all());

        $data = $request->only('parent_id', 'is_featured');
        $offer = Attribute::updateOrCreate(['id' => $id], $data);
        $offer->languages()->syncWithoutDetaching([
            $request->get('language_id') => [
                'name' => $request->get('name')
            ]
        ]);
        return;
    }

    public function destroy($id)
    {
        $attribute = Attribute::where('id', '=', $id)->firstOrFail();
        $attribute->languages()->detach();
        $attribute->categories()->detach();
        $attribute::destroy($id);
        return response(['msg' => 'Attribute deleted']);
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $attribute = new Attribute();
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['name'] = '';
        }
        if ($id > 0) {
            $attribute = Attribute::with('languages')->findOrFail($id);
            foreach ($locales as $shortCode => $languageId) {
                foreach ($attribute->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['name'] = $language->pivot->name;
                    }
                }
            }
            unset($attribute->languages);
        }
        $attribute['translations'] = $translations;
        return $attribute;
    }
}
