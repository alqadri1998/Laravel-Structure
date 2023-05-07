<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SaveTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Libraries\DataTable;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;



class TranslationsController extends Controller
{
    public function __construct() {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbTitle = 'Translations';
    }

    public function index() {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-files-o', 'title' => 'Manage translations'];
        return view('admin.translations.index');
    }

    public function all() {
        $response = [];
        $enData = file_get_contents(base_path('resources/lang/en.json'));
        $arData = file_get_contents(base_path('resources/lang/ar.json'));
        $enData = json_decode($enData, true);
        $arData = json_decode($arData, true);
        $i = 0;
        ((\request('datatable.sort.sort') == "desc") ? arsort($enData) : ksort($enData));
        if (!empty(\request('datatable.query.key'))){
            foreach ($enData as $translationsKey=>$translationsValue){
                if (strpos($translationsKey, request('datatable.query.key')) !== false){
                    if($i==0)
                    {
                        unset($enData);
                        $i++;
                    }
                    $enData[$translationsKey] = $translationsValue;
                }
                else
                {
                    unset($enData[$translationsKey]);
                }
            }
        }
        $length = \request('datatable.pagination.perpage', 10);
        $draw = \request('datatable.pagination.page', 1);
        if(\request('datatable.pagination.page', 1) > 1){
            $start = (\request('datatable.pagination.page', 1) * $length) - $length;

        }else{
            $start = 0;
        }
        $recordsTotal = count($enData);
        if ($recordsTotal > 0){
            $pages = $recordsTotal/10 ;
        }
        else{
            $pages = 0 ;
        }
        $slicedData = [];
        foreach (array_slice($enData, $start, $length) as $key=>$value) {
            if (!empty($key)){
                $slicedData[] = [
                    "key" => $key,
                    "en_value" => $value,
                    "ar_value" => (isset($arData[$key]) ? $arData[$key]: ''),
                    "actions" => '<a href="'.route('admin.translations.edit',$key).'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' .route('admin.translations.destroy',$key).'" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>'
                ];
            }
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

    public function edit($key) {
        $arFile = base_path('resources/lang/ar.json');
        $enFile = base_path('resources/lang/en.json');
        if (file_exists($arFile) && file_exists($enFile)) {
            $enJSON = file_get_contents($enFile);
            $arJSON = file_get_contents($arFile);
            $arTranslations = json_decode($arJSON, true);
            $enTranslations = json_decode($enJSON, true);
            $heading = (($key != 'new') ? 'Edit Translations' : 'Add Translations');
            $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-files-o', 'title' => $heading];
            $arValue = (isset($arTranslations[$key])) ? $arTranslations[$key] : '';
            $enValue = (isset($enTranslations[$key])) ? $enTranslations[$key] : '';
            return view('admin.translations.edit', [
                'heading' => $heading,
                'action' => route('admin.translations.update',   $key),
                'key' => (($key == 'new') ? '': $key),
                'ar_translations' => (($key == 'new') ? '': $arValue),
                'en_translations' => (($key == 'new') ? '': $enValue)
            ]);
        }
        else{
            return redirect()->back()->with('err', 'Json file does not exist.');

        }
    }

    public function update(Request $request, $key) {
        $err = $this->save($request, $key);
        return ($err) ? $err:redirect(route('admin.translations.index'))->with('status', 'Translation has been Updated.');
    }

    private function save($request, $key)
    {
        $enFile = base_path('resources/lang/en.json');
        $arFile = base_path('resources/lang/ar.json');
        $enJSON = file_get_contents($enFile);
        $arJSON = file_get_contents($arFile);
        $enTranslations = json_decode($enJSON, true);
        $arTranslations = json_decode($arJSON, true);
        $translationData = $request->only(['updatedKey', 'en_updatedTranslation', 'ar_updatedTranslation', 'jsonFileKey']);
        if (!empty($translationData['jsonFileKey'])) {
            unset($enTranslations[$translationData['jsonFileKey']]);
            unset($arTranslations[$translationData['jsonFileKey']]);
        }
        $enTranslations[$translationData['updatedKey']] = $translationData['en_updatedTranslation'];
        file_put_contents($enFile, json_encode($enTranslations));
        $arTranslations[$translationData['updatedKey']] = $translationData['ar_updatedTranslation'];
        file_put_contents($arFile, json_encode($arTranslations));
    }

    public function destroy($key) {
        $enFile = base_path('resources/lang/en.json');
        $arFile = base_path('resources/lang/ar.json');
        $enJSON = file_get_contents($enFile);
        $arJSON = file_get_contents($arFile);
        $enTranslations = json_decode($enJSON, true);
        $arTranslations = json_decode($arJSON, true);
        if (!empty($enTranslations[$key])) {
            unset($enTranslations[$key]);
        }
        if (!empty($arTranslations[$key])) {
            unset($arTranslations[$key]);
        }
        file_put_contents($enFile, json_encode($enTranslations));
        file_put_contents($arFile, json_encode($arTranslations));
        return response(['msg' => 'Data deleted']);
    }

    public function exportCsv() {


        // $enData = file_get_contents(base_path('resources/lang/en.json'));
        // $arData = file_get_contents(base_path('resources/lang/ar.json'));
        // $enData = json_decode($enData, true);
        // $arData = json_decode($arData, true);
        // $list = [];
        // foreach ($enData as $key=>$value) {
        //     if (!empty($key)){
        //         $list[] = [
        //             "key" => $key,
        //             "en_value" => $value,
        //             "ar_value" => (isset($arData[$key]) ? $arData[$key]: '')
        //         ];
        //     }
        // }

         Excel::create('Translations', function($excel) {

            $excel->sheet('Translations', function($sheet) {



                $sheet->SetCellValue("A1", "key");
                $sheet->SetCellValue("B1", "en_value");
                $sheet->SetCellValue("C1", "ar_value");
                $i = 1;
                $enData = file_get_contents(base_path('resources/lang/en.json'));
                $arData = file_get_contents(base_path('resources/lang/ar.json'));
                $enData = json_decode($enData, true);
                $arData = json_decode($arData, true);
                foreach ($enData as $key=>$value) {
                     ++$i;
                    if (!empty($key)){
                        $sheet->SetCellValue("A".$i, $key);
                      //  $sheet->SetCellValue("B".$i."", "".$Value."");
                        if(isset($enData[$key])){
                            $sheet->SetCellValue("B".$i, $enData[$key]);
                        }else{
                            $sheet->SetCellValue("B".$i, "");
                        }
                        if(isset($arData[$key])){
                            $sheet->SetCellValue("C".$i, $arData[$key]);
                        }else{
                            $sheet->SetCellValue("C".$i,"");
                        }
                    }
                }

            })->download('xlsx');;
        });    
        return;
        // $headers = [
        //     'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
        //     ,   'Content-type'        => 'text/csv'
        //     ,   'Content-Disposition' => 'attachment; filename=Translations.csv'
        //     ,   'Expires'             => '0'
        //     ,   'Pragma'              => 'public'
        // ];

        // # add headers for each column in the CSV download
        // array_unshift($list, array_keys($list[0]));

        // $callback = function() use ($list)
        // {
        //     $FH = fopen('php://output', 'w');
        //     fputs($FH, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        //     foreach ($list as $row) {
        //         fputcsv($FH, $row);
        //     }
        //     fclose($FH);
        // };
        // return Response::stream($callback, 200, $headers); //use Illuminate\Support\Facades\Response;
         
    }

    public function importExcel(Request $request)
    {
//        try {
//            DB::beginTransaction();
            $now = Carbon::now()->timestamp;
//            $lastId=SpeedIndex::max('id');
            $lastId=0;
            $rowNumber=null;
            $product = [];
            $enArray=[];
            $arArray=[];
            $productLanguages = [];
            $labelProduct=[];
            if (Input::hasFile('import_file')) {
                $path = Input::file('import_file')->getRealPath();
                $data = Excel::load($path, function ($reader) {
                })->get();
                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {
                        if(!empty($value->key)){
                            $rowNumber=$key+2;
                            $enArray[$value->key] = $value['en_value'];
                            if($value['ar_value'])
                            {
                                $arArray[$value['key']]=$value['ar_value'];
                            }
                            else
                            {
                                $arArray[$value['key']]="";
                            }
                        }    
//                      

                    }
//                    dd(json_encode($arArray));

                        $enFile = base_path('resources/lang/en.json');
                        $arFile = base_path('resources/lang/ar.json');
                        file_put_contents($enFile, json_encode($enArray));
                        file_put_contents($arFile, json_encode($arArray));

                    
                }
                return redirect()->back()->with('status','Translation  Imported Successfully');
            }

//            DB::commit();

            return redirect()->back()->with('err','Translation Not Imported Successfully');
    }

}
