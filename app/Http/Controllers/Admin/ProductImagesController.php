<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Image;
use App\Http\Services\ProductService;
use App\Models\ProductImage;
use App\Traits\Cars;
use App\Http\Controllers\Controller;

class ProductImagesController extends Controller
{
    use Cars;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index($productId)
    {
        $productImages = ProductImage::where(['product_Id' => $productId])->get();
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Product Images'];
        return view('admin.product-images.index', ['productId' => $productId, 'productImages' => $productImages]);
    }

    public function store(Image $request)
    {

        $img = new ProductService($request->get("store_id"));

        $err = $img->saveProductImages($request, $request->get("product_id"));
        if ($err) {
            return redirect()->back()->with('status', 'Pictures Insert Successfully.');
        }
        return redirect()->back();
//     ? $err:redirect()->back()->with('status', 'Pictures insert successfully.');;
    }

    public function destroy($productid, $imageId)
    {

        ProductImage::destroy($imageId);

        return response(['msg' => 'Tyre Deleted']);
    }
}
