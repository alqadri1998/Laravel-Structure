<?php

namespace App\Http\Controllers\Front;

use App\Models\Service;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[route('front.services.index')] = ['title' => 'Services'];
    }

    public function index($type = null)
    {

        if (!is_null($type)){
            if ($type == 'maintenance'){
                $this->breadcrumbTitle = "Mechanic";

            }else{
                $this->breadcrumbTitle = ucfirst($type);

            }
            $services = Service::whereHas('languages')->with('languages')->where('type','=', $type)->latest()->paginate(6);
        }else{
            $this->breadcrumbTitle = 'Services';

            $services = Service::whereHas('languages')->with('languages')->where('type','!=', 'repair')->latest()->paginate(6);

        }
        $this->setTranslations($services);
        return view('front.services.list', ['services' => $services]);
    }

    public function detail($slug)
    {

        $service = Service::whereHas('languages')->with('languages')->where('slug', $slug)->firstOrFail();
        $service->translation = $this->translateRelation($service);
        $this->breadcrumbTitle = $service->translation->title;
        $this->breadcrumbs['javascript: {};'] = ['title' => $service->translation->title];

        return view('front.services.detail', ['service' => $service]);
    }
}
