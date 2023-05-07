<?php

namespace App\Http\Controllers\Front;

use App\Models\Repair;
use App\Http\Controllers\Controller;
use App\Models\Service;

class RepairController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[route('front.repairs.index')] = ['title' => 'Repairs'];
    }

    public function index($type = null)
    {
        $this->breadcrumbTitle = 'Repairs';
        $repairs = Service::whereHas('languages')->with('languages')->where('type', 'repair')->latest()->paginate(6);
        $this->setTranslations($repairs);
        return view('front.repairs.list', ['repairs' => $repairs]);
    }

    public function detail($slug)
    {
        $this->breadcrumbTitle = 'Repair';
        $this->breadcrumbs['javascript: {};'] = ['title' => 'Repair'];
        $repair = Service::whereHas('languages')->with('languages')->where('slug', $slug)->firstOrFail();
        $repair->translation = $this->translateRelation($repair);

        return view('front.repairs.detail', ['repair' => $repair]);
    }
}
