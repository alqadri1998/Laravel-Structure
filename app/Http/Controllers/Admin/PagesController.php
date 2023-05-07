<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Requests\SavePage;
use App\Http\Libraries\Uploader;
use App\Http\Libraries\DataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class PagesController extends Controller {

    public function __construct() {
        parent::__construct('adminData', 'admin');
//        $this->middleware('admin.role:crud', ['only' => ['index']]);
//        $this->middleware('admin.role:crud,0', ['only' => ['all']]);
//        $this->middleware('admin.role:create', ['only' => ['create', 'store']]);
//        $this->middleware('admin.role:read', ['only' => ['show']]);
//        $this->middleware('admin.role:update', ['only' => ['edit', 'update']]);
//        $this->middleware('admin.role:update,0', ['only' => ['toggleStatus']]);
//        $this->middleware('admin.role:delete,0', ['only' => ['destroy']]);
        $this->breadcrumbTitle = 'Pages';
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Pages'];
        return view('admin.pages.index');
    }
    public function all(){
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'slug', 'dt' => 'slug'],
            ['db'=> 'page_type','dt' =>'page_type'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
            ['db' => 'deleted_at', 'dt' => 'deleted_at']
        ];
        DataTable::init(new Page, $columns);
        DataTable::with('languages');
        DataTable::where('page_type','=','page');

        $slug = \request('datatable.query.slug','');
        $trashedPages = \request('datatable.query.trashedPages',NULL);
        $createdAt = \request('datatable.query.createdAt','');
        $updatedAt = \request('datatable.query.updatedAt','');
        $deletedAt = \request('datatable.query.deletedAt','');
        $sortOrder = \request('datatable.sort.sort');
        $sortColumn = \request('datatable.sort.field');
        if(!empty($trashedPages)){
            DataTable::getOnlyTrashed();
        }
        if($slug != '') {
            DataTable::where('slug', 'LIKE', '%'.addslashes($slug).'%');
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
        $where = function($query) {
            $title = \request('datatable.query.title', '');
            if(!empty($title)) {
                $query->where('language_page.title', 'LIKE', '%'.addslashes($title).'%');
            }
        };
        if(!empty($sortOrder) && !empty($sortColumn)){
            DataTable::orderBy($sortColumn ,$sortOrder);
        }
        DataTable::with('languages', $where);
        DataTable::whereHas('languages', $where);
        $pages = DataTable::get();
        $count = 0;
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($pages['data']) > 0) {
            $dateFormat = config('settings.date-format');
            foreach ($pages['data'] as $key => $page) {
                $count = $count+1;
                $pages['data'][$key]['en_title'] = '';
                $pages['data'][$key]['en_content'] = '';
                $pages['data'][$key]['ar_title'] = '';
                $pages['data'][$key]['ar_content'] = '';
                $pages['data'][$key]['slug'] = '';
                $pages['data'][$key]['count'] = $count + $perPage;
                foreach ($page['languages'] as $key1 => $translation) {
                    if ($translation->pivot['language_id'] == 2) {
                        $pages['data'][$key]['en_title'] = $translation->pivot->title;
                        $pages['data'][$key]['en_content'] = $translation->pivot->content;
                    } else {
                        $pages['data'][$key]['ar_title'] = $translation->pivot->title;
                        $pages['data'][$key]['ar_content'] = $translation->pivot->content;
                    }
                }

                $pages['data'][$key]['created_at'] = Carbon::createFromTimestamp($page['created_at'])->format($dateFormat);
                $pages['data'][$key]['updated_at'] = Carbon::createFromTimestamp($page['updated_at'])->format($dateFormat);
                if(!empty($trashedPages)){
                    $pages['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill restore-record-button" href="javascript:{};" data-url="' . route('admin.pages.restore',  $page['id']) . '" title="Restore Page"><i class="fa fa-fw fa-undo"></i></a>'.'<span class="m-badge m-badge--danger">'.Carbon::parse($page['deleted_at'])->format($dateFormat).'</span>';

                }else{
                    $pages['data'][$key]['actions'] = '<a href="'.route('admin.pages.edit', $page['id']).'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' ;
//                        .
//                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="'. route('admin.pages.destroy', $page['id']).'" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
                $pages['data'][$key]['slug'] = $page['slug'];
            }
        }

        return response($pages);
    }

    private function save($request, $id = 0) {
        $data = [];
//        $data['image'] = $request->get('image');
        $translation = $request->only(['language_id', 'title']);
        if ($request->hasFile('image')) {
            $uploader = new Uploader('image');
            if ($uploader->isValidFile()) {
                $uploader->upload('pages', $uploader->fileName);
                if ($uploader->isUploaded()) {
                    $data['image'] = $uploader->getUploadedPath();
                }
            }
            if (!$uploader->isUploaded()) {
                return redirect()->back()->with('err', $uploader->getMessage())->withInput();
            }
            $page = Page::find($id);
            if (!is_null($page->image)){
                File::delete(env('PUBLIC_BASE_PATH').$page->getOriginal('image'));
            }
        }


        $translation['content']=$request->content;
        if ($request->get('language_id') == 2){
            $data['slug'] = str_slug($translation['title']);
            $pageTranslationQuery = Page::where(['slug' => $data['slug']]);
            if ($id > 0) {
                $pageTranslationQuery->where('id', '!=', $id);
            }
            $pageWithSlug = $pageTranslationQuery->first();
            if ($pageWithSlug !== null) {
                return redirect()->back()->withInput()->with('err', 'Page with same name already exists.');
            }
        }
//        event(new Notifications('page_edit', route('admin.pages.edit', ['id' => $id])));
        if($id==0 && empty($data['image']))
        {
            $data['image']=url('images/productDetail.png');
        }
        $page = Page::updateOrCreate(['id' => $id], $data);
        $page->languages()->syncWithoutDetaching([$translation['language_id']=>$translation]);
        return;
    }
    public function edit($id) {


        $heading = (($id > 0) ? 'Edit Page':'Add Page');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.pages.edit', [
            'method' => 'PUT',
            'pageId' => $id,
            'action' => route('admin.pages.update', $id),
            'heading' => $heading,
            'page' => $this->getViewParams($id)
        ]);
    }

    public function update(savePage $request, $id) {
//        dd($request->all());
        $err = $this->save($request, $id);
        return ($err) ? $err:redirect(route('admin.pages.index'))->with('status', 'Page updated successfully.');
    }

    private function getViewParams($id = 0) {

        $translations[2]['title'] = '';
        $translations[2]['content'] = '';
        $translations[2]['short_content'] = '';
        $translations[1]['title'] = '';
        $translations[1]['content'] = '';
        $translations[1]['short_content'] = '';
        $page = new Page();
        if ($id > 0) {
            $page = Page::with(['languages'])->findOrFail($id);
            foreach ($page->languages as $key => $language) {
                if ($language->id==config('app.locales.en')) {
                    $translations[2]['title'] = $language->pivot->title;
                    $translations[2]['content'] = $language->pivot->content;
                    $translations[2]['short_content'] = $language->pivot->short_content;
                }
                else {
                    $translations[1]['title'] = $language->pivot->title;
                    $translations[1]['content'] = $language->pivot->content;
                    $translations[1]['short_content'] = $language->pivot->short_content;
                }
            }
            unset($page->languages);
        }
        $page->translations = $translations;

        return $page;
    }

    public function destroy($id) {
        Page::destroy($id);
        return response(['msg' => 'Page deleted']);
    }

    public function bulkDelete($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $key=>$value){
            Page::destroy($value);
        }
        return response(['msg' => 'Pages deleted successfully.']);
    }


    public function restore($id) {
        Page::withTrashed()->where('id',$id)->update(['deleted_at'=>NULL]);
        return response(['msg' => 'Page restored successfully.']);
    }

    public function bulkRestore($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $key=>$value){
            Page::withTrashed()->where('id',$value)->update(['deleted_at'=>NULL]);
        }
        return response(['msg' => 'Pages restored successfully.']);
    }

}
