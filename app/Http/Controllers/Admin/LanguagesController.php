<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Libraries\DataTable;

class LanguagesController extends Controller
{
    public function __construct() {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbTitle = 'Languages';
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }

    public function index() {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-files-o', 'title' => 'Manage Languages'];
        return view('admin.languages.index');
    }

    public function all() {
        $columns = [
            ['db' => 'title', 'dt' => 'title'],
            ['db' => 'short_code', 'dt' => 'short_code'],
        ];
        DataTable::init(new Language(), $columns);
        $languages = DataTable::get();
        if (sizeof($languages['data']) > 0) {
            foreach ($languages['data'] as $key => $data) {
                $languages['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="'. route('admin.languages.translations.index',['languages'=>$data['short_code']]).'" title="Translation"><i class="fa fa-language"></i></a>';
            }
        }
        return response($languages);
    }

    public function edit($id) {
        $heading = (($id > 0) ? 'Edit Languages':'Add Languages');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-files-o', 'title' => $heading];
        return view('admin.languages.edit',[
            'heading' => $heading,
            'action' => route('admin.languages.update', ['languages' => $id])
        ]);
    }

    public function update(Request $request, $id) {
        $err = $this->save($request, $id);
        if (!$err) {
            return redirect()->back()->with('status', 'Template updated');
        }
        return $err;
    }

    private function save($request, $id=0) {
        $sectionData = $request->only(['title', 'header_id', 'footer_id', 'sidebar_id', 'is_default']);
        if ($sectionData['is_default'] ==1) {
            Template::where('id','!=', $id)->update(['is_default'=>0]);
        }
        Template::updateOrCreate(['id'=>$id], $sectionData);
    }

    public function store(SaveSections $request) {
        $err = $this->save($request);
        return ($err) ? $err:redirect(route('admin.templates.index'))->with('status', 'Template Saved');
    }


}
