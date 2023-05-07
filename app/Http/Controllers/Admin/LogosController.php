<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Uploader;
use App\Http\Requests\Image;
use App\Models\Logo;
use Illuminate\Http\Request;

class LogosController extends Controller
{
    public function __construct() {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }

    public function index()
    {
        $logoImages = Logo::get();
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Partners Logo'];
        return view('admin.Logo.index', ['logoImages' => $logoImages]);
    }

    public function create()
    {
    }
    public function store(Image $request)
    {
        $data = $request->except('_token');
        $uploader = new Uploader();
        if (isset($data['images']) && count($data['images']) > 0) {

            $default_path = '';

            $file_name = '';

            foreach ($data['images'] as $key => $img) {
                if (is_object($img)) {

                    $uploader->setFile($img);

                    if ($uploader->isValidFile()) {

                        $file_name = $uploader->fileName;

                        $uploader->upload('logo-images',$file_name);

                        if ($uploader->isUploaded()) {

                            $logoImages[] = $uploader->getUploadedPath();

                        }
                    }
                    else{
                        return redirect()->back()->with('err', 'Picture Is Invalid');

                    }

                }

            }

        }
        foreach ($logoImages as $key => $image) {
            Logo::create(['image' => $image]);

        }
        return redirect()->back()->with('status', 'Pictures Uploaded Successfully.');



    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        Logo::destroy($id);

        return response(['msg' => 'Logo Deleted']);
    }
}
