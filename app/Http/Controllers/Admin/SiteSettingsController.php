<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\Uploader;
use App\Http\Requests\SiteSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveSiteSettings;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


class SiteSettingsController extends Controller {

    public function __construct() {
        parent::__construct('adminData', 'admin');
        $this->middleware('admin.role:crud', ['only' => ['index']]);
        $this->middleware('admin.role:create', ['only' => ['create', 'store']]);
        $this->middleware('admin.role:read', ['only' => ['show']]);
        $this->middleware('admin.role:update', ['only' => ['edit', 'update']]);
        $this->middleware('admin.role:delete,0', ['only' => ['destroy']]);
        $this->breadcrumbTitle = 'Site Settings';
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }

    public function index() {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-cog', 'title' => 'Site Settings'];
        return view('admin.site_settings.index');
    }

    public function arrayFlatten($array, $netKey='') {
        if (!is_array($array)) {
            return $array;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result,$this->arrayFlatten($value,$netKey.$key.'.'));
            }
            else {
                $result[$netKey.$key] = $value;
            }
        }
        return $result;
    }

    public function all(){
        $settings = config('settings');
        $response = [];
        $data = $this->arrayFlatten($settings);
        ((\request('datatable.sort.sort') == "desc") ? arsort($data) : ksort($data));
        if (!empty(\request('datatable.query.key'))){
            foreach ($data as $settingsKey=>$settingsValue){
                if(strpos($settingsKey, request('datatable.query.key')) !== false){
                    unset($data);
                    $data[$settingsKey] = $settingsValue;
                }
            }
        }
        $length = \Illuminate\Support\Facades\Request::input('datatable.pagination.perpage', 10);
        $draw = \Illuminate\Support\Facades\Request::input('datatable.pagination.page', 1);
        if(\Illuminate\Support\Facades\Request::input('datatable.pagination.page', 1) > 1){
            $start = (\Illuminate\Support\Facades\Request::input('datatable.pagination.page', 1) * $length) - $length;
        }else{
            $start = 0;
        }
        $recordsTotal = count($data);

        if ($recordsTotal > 0){
            $pages = $recordsTotal/10 ;
        }
        else{
            $pages = 0 ;
        }
        $slicedData = [];
        $count =0;
//        $perPage = \request('datatable.pagination.perpage', 1);
//        $page = \request('datatable.pagination.page', 1);

//        if the user is on page other then 1st.
//        and changes the page size, this will reset the table and re-enter the table using new page size.
//        and start the pagination from 1, with new page size.
//        other wise it does not show any data due to array_slice which sets the offset to 200, if 100 page size is set, and we do not have 200+ site settings.
        if ($draw > 1 && $length > count($data)){
            $start = 0;
            $draw = 1;
        }
        $perPage = ($draw * $length) - $length;

        foreach (array_slice($data, $start, $length) as $key=>$value) {
            $count = $count +1;

            if($key=='logo' || $key=='login_page_image'||$key=='email_logo' )
            {
                $value='<img src="'.url($value).'" style="height:100px;">';
            }
            $slicedData[] = [
                "id" => $count + $perPage,
                "key" => $key,
                "value" => $value,
                "actions" => '<a href="'.route('admin.site-settings.edit',$key).'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></i></a>'
//                    .'<a href="'.route('admin.site-settings.delete',$key).'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-trash-o"></i></i></a>'
            ];
        }

        $meta = [
            "page" => intval($draw),
            "pages" => intval($pages),
            "total" => intval($recordsTotal),
            "perpage" => intval($length),
            "start" => intval($start)
        ];
        $response['meta'] = $meta;
        $response['data'] = $slicedData;
        return response()->json($response);

    }
    public function edit($key){

        $result = [];
//        $heading = (($key !== "0") ? 'Edit Languages':'Add Languages');
        if($key !== "0" ){
            $value = config('settings.'.$key);
            $result['key'] = $key;
            $result['value'] = $value;
            $heading = ('Edit '.$key);
        }else{
            $heading = ('Add Value');
            $result['key']="";
            $result['value']="";
        }
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-files-o', 'title' => $heading];

        return view('admin.site_settings.edit', [
            'heading'=> $heading,
            'action' => route('admin.site-settings.update', ['key' => $key]),
            'result' => $result
        ]);
    }
    public function store(SiteSetting $request) {

        $siteSettings = $request->only(['key', 'value','image']);

        if($request->key=='logo' || $request->key=='login_page_image' || $request->key=='email_logo' || $request->key=='product_slider'  )
        {
            if(empty($request->image))
            {
                $siteSettings['value']=config('settings.'.$request->key);
            }
            else
            {
                $siteSettings['value']=$request->image;
            }
        }

        \Config::set('settings.'.$siteSettings['key'], $siteSettings['value']);
        $settings = serialize(config('settings'));
        $file = base_path('config/settings.php');
        $data = "<?php return unserialize(base64_decode('".base64_encode($settings)."'));";

        file_put_contents($file, $data);
        Artisan::call('config:clear');
        \Cache::forget('settings');
        return redirect(route('admin.site-settings.index'))->with('status', 'Site setting has been updated successfully.');
    }

    public function delete($key) {
        $settings = config('settings');
        array_forget($settings,$key);
        $settings = serialize($settings);
        $file = base_path('config/settings.php');
        $data = "<?php return unserialize(base64_decode('".base64_encode($settings)."'));";
        file_put_contents($file, $data);
        Artisan::call('config:clear');
        \Cache::forget('settings');
        return response(['msg' => 'Site setting deleted successfully.']);
    }

    public function clearRouteCache(){
        Artisan::call('route:clear');
        return response(['msg'=>'Route cache cleared successfully.']);
    }

    public function clearStorageCache(){
        Artisan::call('cache:clear');
        return response(['msg'=>'Storage cache cleared successfully.']);
    }

    public function clearConfigCache(){
        Artisan::call('config:clear');
        return response(['msg'=>'Config cache cleared successfully.']);
    }

    public function clearViewCache(){
        Artisan::call('view:clear');
        return response(['msg'=>'View cache cleared successfully.']);
    }
}
