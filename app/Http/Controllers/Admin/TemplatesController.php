<?php namespace App\Http\Controllers\Admin;

use App\Models\Template;
use App\Http\Requests\TemplateRequest;
use App\Http\Libraries\DataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TemplatesController extends Controller {

    public function __construct() {
        parent::__construct('adminData', 'admin');
        $this->middleware('admin.role:crud', ['only' => ['index']]);
        $this->middleware('admin.role:crud,0', ['only' => ['all']]);
        $this->middleware('admin.role:create', ['only' => ['create', 'store']]);
        $this->middleware('admin.role:read', ['only' => ['show']]);
        $this->middleware('admin.role:update', ['only' => ['edit', 'update']]);
        $this->middleware('admin.role:update,0', ['only' => ['toggleStatus']]);
        $this->middleware('admin.role:delete,0', ['only' => ['destroy']]);
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Template'];
        return view('admin.templates.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'title', 'dt' => 'title'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
            ['db' => 'deleted_at', 'dt' => 'deleted_at'],
        ];
        DataTable::init(new Template, $columns);

        $trashedTemplates = \request('datatable.query.trashedTemplates', NULL);
        $createdAt = \request('datatable.query.createdAt','');
        $updatedAt = \request('datatable.query.updatedAt','');
        $deletedAt = \request('datatable.query.deletedAt','');
        $emailTitle = \request('datatable.query.emailTitle', '');

        if(!empty($trashedTemplates)){
            DataTable::getOnlyTrashed();
        }

        if($createdAt != '') {
            $createdAt =  Carbon::createFromFormat('m/d/Y', $createdAt);
            $cBetween = [$createdAt->hour(0)->minute(0)->second(0)->timestamp, $createdAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('created_at', $cBetween);
        }

        if($updatedAt != '') {
            $updatedAt =  Carbon::createFromFormat('m/d/Y', $updatedAt);
            $uBetween = [$updatedAt->hour(0)->minute(0)->second(0)->timestamp, $updatedAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('updated_at', $uBetween);
        }

        if(!empty($deletedAt)){
            $sWhere = function($query) use ($deletedAt) {
                $deletedAt = Carbon::createFromFormat('m/d/Y', $deletedAt);
                $dBetween = [$deletedAt->hour(0)->minute(0)->second(0)->timestamp, $deletedAt->hour(23)->minute(59)->second(59)->timestamp];
                $query->whereBetween('deleted_at',$dBetween);
            };
            DataTable::getOnlyTrashed($sWhere);
        }

        if(!empty($emailTitle)) {
            DataTable::where('title', 'LIKE', '%'.addslashes($emailTitle).'%');
        }
        $templates = DataTable::get();
        if (sizeof($templates['data']) > 0) {
            $dateFormat = config('settings.date-format');
            foreach ($templates['data'] as $key => $data) {
                $templates['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                $templates['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                if(!empty($trashedTemplates)){
                    $templates['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill restore-record-button" href="javascript:{};" data-url="' . route('admin.templates.restore', ['templates' => $data['id']]) . '" title="Restore Template"><i class="fa fa-fw fa-undo"></i></a>'.'<span class="m-badge m-badge--danger">'.Carbon::createFromTimestamp($data['deleted_at'])->format($dateFormat).'</span>';
                }else {
                    $templates['data'][$key]['actions'] = '<a href="' . route('admin.templates.edit', ['templates' => $data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.templates.destroy', ['templates' => $data['id']]) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
            }
        }
        return response($templates);
    }

    private function save($request, $id = 0) {

        $data['title'] = '';
        $data['title'] = $request->get('title');
        $data['template'] = $request->get('template');
        Template::updateOrCreate(['id' => $id], $data);
        return;
    }

    public function edit($id) {
        $heading = (($id > 0) ? 'Edit Template':'Add Template');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.templates.edit', [
            'method' => 'PUT',
            'templateId' => $id,
            'action' => route('admin.templates.update', $id),
            'heading' => $heading,
            'template' => $this->getViewParams($id)
        ]);
    }

    public function update(TemplateRequest $request, $id) {
        $err = $this->save($request, $id);
        return ($err) ? $err:redirect(route('admin.templates.index'))->with('status', 'Template updated');
    }

    private function getViewParams($id = 0) {
        $template = new Template();
        if ($id > 0){
            $template = Template::where(['id'=>$id])->first();
        }
        return $template;
    }

    public function destroy($id) {
        Template::destroy($id);
        return response(['msg' => 'Template deleted']);
    }

    public function bulkDelete($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $key=>$value){
            Template::destroy($value);
        }
        return response(['msg' => 'Faqs deleted successfully.']);
    }


    public function restore($id) {
        Template::withTrashed()->where('id',$id)->update(['deleted_at'=>NULL]);
        return response(['msg' => 'Faq restored successfully.']);
    }

    public function bulkRestore($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $key=>$value){
            Template::withTrashed()->where('id',$value)->update(['deleted_at'=>NULL]);
        }
        return response(['msg' => 'Faqs restored successfully.']);
    }

}
