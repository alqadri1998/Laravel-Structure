<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Uploader;
use App\Http\Requests\Image;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{

    public function __construct() {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }
    public function index()
    {
        $sliderImages = Slider::get();
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage slider Images'];
        return view('admin.slider.index', ['sliderImages' => $sliderImages]);
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

                            $uploader->upload('slider-images',$file_name);

                            if ($uploader->isUploaded()) {

                                $sliderImages[] = $uploader->getUploadedPath();

                            }
                        }
                        else{
                            return redirect()->back()->with('err', 'Picture is invalid');

                        }

                    }

                }

            }
            foreach ($sliderImages as $key => $image) {
                Slider::create(['image' => $image]);

            }
        return redirect()->back()->with('status', 'Slider Image Uploaded Successfully.');




    }
    public function show($id)
    {
    }


    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);

        if ($slider->delete()){
            File::delete(env('PUBLIC_BASE_PATH').$slider->image);
        }

        return response(['msg' => 'Product Deleted']);
    }
}
