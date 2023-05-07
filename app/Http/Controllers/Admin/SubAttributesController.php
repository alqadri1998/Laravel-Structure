<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Libraries\DataTable;
use App\Http\Requests\FromValidation;
use App\Models\Attribute;
use App\Traits\GetAttributes;
use Illuminate\Support\Carbon;

class SubAttributesController extends Controller
{
    use GetAttributes;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');

        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index($parentId){
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Sub Attributes'];
        return view('admin.attributes.subAttributes', ['id' => $parentId]);
    }

    public function edit($parentId, $id)
    {
        $url = explode('/', url()->previous());
        $heading = (($id > 0) ? 'Edit Subattribute' : 'Add Subattribute');
        $this->breadcrumbs[route('admin.attributes.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Attributes'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.sub-attributes.edit', [
            'method' => 'PUT',
            'attributeId' => $id,
            'parent' => $parentId,
            'attribute' => $this->getViewParams($id),
            'action' => route('admin.attributes.sub-attributes.update', [$parentId, $id])
        ]);
    }

    public function update(FromValidation $request, $parentID, $id)
    {
        $err = $this->save($request, $id);
        if ($id == 0) {
            return ($err) ? $err : redirect(route('admin.attributes.index'))->with('status', 'Sub Attribute Added ');
        } else {
            return ($err) ? $err : redirect(route('admin.attributes.index', $parentID))->with('status', 'Sub Attributes Updated');

        }
    }

    public function save($request, $id)
    {
        $data = $request->only('parent_id');
        if ($request->has('image') && $request->image != '') {
            $data['image'] = $request->get('image');
        }
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
    }

    public function all($id)
    {
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'parent_id', 'dt' => 'parent_id'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        DataTable::init(new Attribute(), $columns);
        DataTable::with('languages');
        DataTable::whereHas('languages');
        DataTable::where('parent_id', '=', $id);
        $dateFormat = config('settings.date-format');
        $subAttribute = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * 10) - $perPage;
        if (sizeof($subAttribute['data']) > 0) {
            foreach ($subAttribute['data'] as $key => $data) {
                $count = $count + 1;
                $subAttribute['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                $subAttribute['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                $subAttribute['data'][$key]['name'] = '';
                $subAttribute['data'][$key]['id'] = $count + $perPage;
                if (count($data['languages']) > 0) {
                    $subAttribute['data'][$key]['name'] = $data['languages'][0]->pivot->name;
                }
                unset($subAttribute['data'][$key]['languages']);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $subAttribute['data'][$key]['actions'] = '<a href="' . route('admin.attributes.sub-attributes.edit', [$id, $data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $subAttribute['data'][$key]['actions'] = '<a href="' . route('admin.attributes.sub-attributes.edit', [$id, $data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.attributes.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($subAttribute);
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
