<?php

namespace App\Http\Controllers\Admin;

use App\Http\Libraries\Uploader;
use App\Http\Requests\Image;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Event;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Role;
use App\Traits\Upload;
use Illuminate\Http\Request;
use App\Traits\Administrators;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    use Administrators, Upload;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];

        $this->breadcrumbTitle = 'Dashboard';
    }

    public function randomColour()
    {
        // Found here https://css-tricks.com/snippets/php/random-hex-color/
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
        return $color;
    }

    public function index()
    {
        if ($this->user['role_id'] == config('settings.supplier_role')) {
            $supplierCount = Admin::where('role_id', '=', config('settings.supplier_role'))->count();
            $pendingOrders = '';
            $deliveredOrders = '';
            $completeOrders = '';
            $outstandingInvoices = '';

            $completeInvoices = '';
            $partiallyPaidInvoices = '';
            $totalClaims = '';
            $totalOutstandingDeliveries = '';

        } else {
            $supplierCount = Admin::where('role_id', '=', config('settings.supplier_role'))->count();
            $pendingOrders = '';
            $deliveredOrders = '';
            $completeOrders = '';
            $outstandingInvoices = '';
            $completeInvoices = '';
            $partiallyPaidInvoices = '';
            $totalClaims = '';
            $totalOutstandingDeliveries = '';
        }
        $totalProducts = Product::where('type', 'product')->count();
        $totalPackages = Product::where('type', 'package')->count();
        return view('admin.home', [
            'totalProducts' => $totalProducts,
            'totalPackages' => $totalPackages,
            'pendingOrders' => Order::where('order_status', '=', 'confirmed')->count(),
            'inProgressOrders' => Order::where('order_status', '=', 'In progress')->count(),
            'completeOrders' => Order::where('order_status', '=', 'completed')->count(),
            'coupons' => Coupon::count(),
            'promotions' => Promotion::count(),
            'categories' => Category::count(),
        ]);
    }

    public function editProfile()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' =>'Edit Profile'];

        return view('admin.edit_profile', ['languageId' => 1]);
    }

    public function updateProfile(Request $request)
    {

        $rules = [
            'full_name' => 'required|max:60|regex:/^[a-z0-9\-\s]+$/i',
            'user_name' => 'required',
            'email' => 'required|email|max:100|unique:admins,email,' . $this->user['id'] . ',id',
            'password' => 'required|between:6,32|alpha_num|confirmed',
            /*'profile_pic' => 'image',*/
        ];
        if (empty($request->get('password'))) {
            unset($rules['password']);
        }
        $this->validate($request, $rules);

        $data = $request->only('full_name', 'user_name', 'email', 'address', 'longitude', 'latitude');
        if ($request->has('image') && $request->image != '') {
            $data['profile_pic'] = $request->get('image');
        }
        if (!empty($request->get('password'))) {
            $data['password'] = bcrypt($request->get('password'));
        }
        $adminId = session('ADMIN_DATA.id');
        $adminData = Admin::updateOrCreate(['id' => $adminId], $data);
        $adminData['token'] = session('ADMIN_DATA.token');
        $adminData = $adminData->toArray();
        session()->forget('ADMIN_DATA');
        session()->put('ADMIN_DATA', $adminData);
        return redirect()->back()->with('status', 'Profile updated successfully.');
    }

    public function all($type, $pro)
    {
//        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
//            ['db' => 'phone', 'dt' => 'phone'],
//            ['db' => 'rate_per_hour', 'dt' => 'rate'],
//        ];
//        DataTable::init(new Company, $columns);
//        DataTable::with('companyTranslations');
//        if($pro == 0){
//            $where = ['company_type' => $type, 'pro_check' => $pro];
//        }else{
//            $where = [ 'pro_check' => $pro];
//        }
//        $companies = DataTable::get($where);
//        if (sizeof($companies['data']) > 0) {
//            foreach ($companies['data'] as $key => $company) {
//                $companies['data'][$key]['full_name'] = '';
//                foreach ($company['companyTranslations'] as $key1 => $translation) {
//                    if ($translation->language_id == 2) {
//                        $companies['data'][$key]['full_name'] =  $translation['full_name'];
//                    } else {
//                        $companies['data'][$key]['full_name'] =  $translation['full_name'];
//                    }
//                }
//                $companies['data'][$key]['rate'] = 'USD '.$company['rate'];
//                $companies['data'][$key]['actions'] =
//                    '<a href="'.route('admin.companies.employees.index', ['company' => $company['id']]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-user"></i></a>' .
//                    '<a href="'.route('admin.companies.edit', ['company' => $company['id']]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' .
//                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="'. route('admin.companies.destroy', ['company' => $company['id']]).'" title="Delete"><i class="la la-trash"></i></a>';
//
//            }
//        }
//        return response($companies);
    }

    public function activateMaintenanceMode()
    {
        if ($this->user['role_id'] == Role::superSystemAdminRoleId() && $this->user['id'] == Admin::superSystemAdminId) {
            \Artisan::call('down');
            session()->put('maintenanceMode', 0);
            return redirect()->back()->with('status', 'Maintenance mode activated successfully');
        }
        return redirect()->back()->with('err', 'Permission denied!');
    }

    public function activateLiveMode()
    {
        if ($this->user['role_id'] == Role::superSystemAdminRoleId() && $this->user['id'] == Admin::superSystemAdminId) {
            \Artisan::call('up');
            session()->put('maintenanceMode', 1);
            return redirect()->back()->with('status', 'Maintenance mode de-activated successfully, site is live now');
        }
        return redirect()->back()->with('err', 'Permission denied!');
    }

    public function saveImage(Request $request)
    {
        $imageData = ['file' => ''];
        $imageResponse = $this->handleImage($request, $imageData, 'cms_pages', 'file');
        if ($imageResponse['status'] <= 0) {
            return response(['location' => ''])->setStatusCode(400, $imageResponse['message']);
        }
        return response(['location' => url($imageData['file'])]);
    }

    public function getPublicImages()
    {
        $folderName = \request()->get('folder');
        $dir = env('GALLERY_BASE_PATH') . $folderName;
        $images = scandir($dir);
        foreach ($images as $key => $value) {
            $pathInfo = pathinfo($value);
            /*if (!isset($pathInfo['extension'])){
                $images[$key] = 'images/download.png';
            }else{
                $images[$key] = 'uploads/'.$folderName.'/'.$value;
            }*/
            $images[$key] = $pathInfo;
        }
        return response(['status_code' => 201, 'message' => $folderName . ' Images', 'data' => $images]);
    }

    public function deletePublicImage()
    {
        $imagePath = \request()->get('image_path');
        $filePath = public_path($imagePath);
        unlink($filePath);
        return response(['status_code' => 200, 'message' => 'Image deleted successfully.']);
    }

    public function uploadImage(Image $request)
    {
        $imageUploadedPath = '';
        if ($request->hasFile('image')) {
            $uploader = new Uploader('image');
            if ($uploader->isValidFile()) {
                $uploader->upload('media', $uploader->fileName);
                if ($uploader->isUploaded()) {
                    $imageUploadedPath = $uploader->getUploadedPath();
                }
            }
            if (!$uploader->isUploaded()) {
                return 0;
            }
        }
        return response(['status_code' => '200', 'message' => 'Image uploaded successfully.', 'data' => $imageUploadedPath]);
    }

    public function file()
    {
        dd(imageUrl('uploads/media/Career-1570111183.jpg', 120, 120, 100, 1));
        return view('uploadfile');
    }
}
