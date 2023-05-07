<?php namespace App\Http\Controllers\Admin;

use App\Events\CartChangeNotifications;
use App\Events\newNotifications;
use App\Http\Libraries\ResponseBuilder;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Libraries\DataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Traits\GetAttributes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    use GetAttributes;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->breadcrumbTitle = 'Tyres';
    }

    public function index()
    {

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Tyres'];
        return view('admin.products.index');
    }

    public function all()
    {
        $columns = [
//            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'price', 'dt' => 'price'],
            ['db' => 'quantity', 'dt' => 'quantity'],
            ['db' => 'discount', 'dt' => 'discount'],
            ['db' => 'offer', 'dt' => 'offer'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
        ];
        $categoryLanguages = function ($query) {
            $query->with('languages');

        };
        $count = 0;
        DataTable::init(new Product, $columns);
        DataTable::with('categories', $categoryLanguages);
        DataTable::where('type', '=', 'product');
//        $trashedPages = \request('datatable.query.trashedPages',NULL);
//        $createdAt = \request('datatable.query.createdAt','');
//        $season=\request('datatable.query.season','');
//        $brand=\request('datatable.query.brand','');
//        $vehicle=\request('datatable.query.vehicle','');
//        $deliveryType=\request('datatable.query.deliveryType','');
//        $speedIndex=\request('datatable.query.speedIndex','');
//        $carModelId=\request('datatable.query.carModelId','');
//        $size=\request('datatable.query.size','');
//        $updatedAt = \request('datatable.query.updatedAt','');
//        $deletedAt = \request('datatable.query.deletedAt','');
//        $itemCode = \request('datatable.query.itemCode','');
//        $sortOrder = \request('datatable.sort.sort');
//        $sortColumn = \request('datatable.sort.field');


        $where = function ($query) {
            $title = \request('datatable.query.title', '');
            if (!empty($title)) {
                $query->where('language_product.title', 'LIKE', '%' . addslashes($title) . '%');
            }
        };
        DataTable::with('languages', $where);
        DataTable::whereHas('languages', $where);
        $product = DataTable::get();

        $count = 0;
        $dateFormat = config('settings.date-format');
        $perPage = \request('datatable.pagination.perpage', 1);
        $page = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;
        if (sizeof($product['data']) > 0) {
            foreach ($product['data'] as $key => $data) {
                $count = $count + 1;
                $product['data'][$key]['id'] = $count + $perPage;
                $product['data'][$key]['title'] = '';
                $product['data'][$key]['category'] = '';
                $product['data'][$key]['discount'] = 'None';
                $product['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                $product['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
                if ($this->user['role_id'] == config('settings.supplier_role')) {
                    $product['data'][$key]['actions'] = '<a href="' . route('admin.product.product-detail', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Add to Cart"><i class="fas fa-shopping-cart"></i></a>';
                } else {
                    $product['data'][$key]['actions'] = '<a href="' . route('admin.products.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
//                        '<a href="' . route('admin.product.product-detail', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Product Details"><i class="fas fa-shopping-cart"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.products.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
                if ($data['offer'] == 1) {
                    $product['data'][$key]['discount'] = round($data['discount'], 2);
                }

                if (count($data['languages']) == 2) {
                    foreach ($data['languages'] as $language) {
                        if ($language->id == 2) {
                            $product['data'][$key]['title'] = $language->pivot->title;
                            $product['data'][$key]['long_description'] = $language->pivot->long_description;
                            $product['data'][$key]['short_description'] = $language->pivot->short_description;
                        }
                    }
                } elseif (count($data['languages']) == 1) {
                    $product['data'][$key]['title'] = $data['languages'][0]->pivot->title;
                    $product['data'][$key]['long_description'] = $data['languages'][0]->long_description;
                    $product['data'][$key]['short_description'] = $data['languages'][0]->pivot->short_description;
                }
                unset($product['data'][$key]['languages']);
                if (count($product['data'][$key]['categories']) == 1) {

                    $product['data'][$key]['category'] = $product['data'][$key]['categories'][0]['languages'][0]->pivot->name;
                }
                if (count($product['data'][$key]['categories']) == 2) {
                    $product['data'][$key]['category'] = $product['data'][$key]['categories'][0]['languages'][0]->pivot->name . ' > ' . $product['data'][$key]['categories'][1]['languages'][0]->pivot->name;

                }
                if (count($product['data'][$key]['categories']) == 3) {
                    $product['data'][$key]['category'] = $product['data'][$key]['categories'][0]['languages'][0]->pivot->name . ' > ' . $product['data'][$key]['categories'][1]['languages'][0]->pivot->name . ' > ' . $product['data'][$key]['categories'][2]['languages'][0]->pivot->name;

                }
                unset($product['data'][$key]['categories']);

            }
        }
        return response($product);

    }

    private function save($request, $id = 0)
    {
//        Delete images that are no longer in use.
//        because we get image locations everytime we update, we cannot just delete the images from public folder because the same name will be saved(database) in update.
//        we have to compare and only delete the ones that are no longer being sent from the form.
        $databaseImages = [];
        $requestImages = [];
        if ($id > 0) {
            $images = ProductImage::where('product_id', $id)->get();
            if (count($images) > 0){
                foreach ($images as $image){
                   array_push($databaseImages, $image->image);
                }
                foreach ($request->images as $requestImage){
                    array_push($requestImages, $requestImage['image']);
                }
                foreach($databaseImages as $oldImage){
                    if (!in_array($oldImage,$requestImages)){
//                        unlink(public_path($oldImage));
                        File::delete(env('PUBLIC_BASE_PATH').$oldImage);
                    }
                }
            }
            ProductImage::where('product_id', $id)->delete();
        }

        if (!$request->exists('offer')) {
            $request['discount'] = $request->price;
            $request['offer'] = 0;
        }

        $data = $request->only('price', 'quantity', 'discount_percent', 'offer', 'image', 'year', 'sku');

        if ($request->offer == 1) {
            $data['discount'] = $data['price'] * ((100 - $data['discount_percent']) / 100);
        }

        $data['images_dependent'] = ($request->imagesDependent == true) ? 1 : 0;
        $data['slug'] = str_slug($request->titleEn);

        $data['brand_id'] = $request->brand;
        $data['origin_id'] = $request->origin;
        $data['promotion_id'] = $request->promotion;


        $productExist = Product::where('slug', $data['slug'])->first();
        if ($productExist !== null) {
            $data['slug'] = $this->incrementSlug($data['slug'], $id);
        }
        if ($request->has('vat')) {
            $data['vat'] = $request->vat;
        } else {
            $data['vat'] = 0;
        }

        $product = Product::updateOrCreate(['id' => $id], $data);
//        dd($request->all());
        if ($request->has('images')) {
            $productImages = [];
            foreach ($request->images as $imageObject) {
                $productImages[] = ['product_id' => $product->id, "image" => $imageObject['image'], 'default_image' => ($imageObject['isDefault'] == true) ? 1 : 0];
            }
            ProductImage::insert($productImages);
        }


        $product->languages()->syncWithoutDetaching([
            1 => [
                'title' => $request->get('titleAr'),
                'long_description' => $request->get('descriptionAr')
            ],
            2 => [
                'title' => $request->get('titleEn'),
                'long_description' => $request->get('descriptionEn')
            ],
        ]);
        if ($request->exists('mainAttributes')) {
            $product->attributes()->detach();
            foreach ($request->mainAttributes as $attribute) {
                $product->attributes()->syncWithoutDetaching([
                    $attribute['attribute_id'] => [
                        'parent_attribute_id' => $attribute['parent_attribute_id'],
                        'images_dependent' => ($attribute['imagesDependent'] == true) ? 1 : 0,
                        'images' => (isset($attribute['images']) && count($attribute['images']) > 0) ? json_encode($attribute['images']) : null]
                ]);
            }

        }


        $product->categories()->sync([$request->category, $request->subcategory, $request->subsubcategory]);
        return;
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Tyre' : 'Add Tyre');
        $this->breadcrumbs[route('admin.products.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Tyres'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.products.edit', [
            'method' => 'PUT',
            'productId' => $id,
            'action' => route('admin.products.update', $id),
            'heading' => $heading,
            'category' => arr::except($this->getCategories(), 0),
            'product' => $this->getViewParams($id),
            'brand' => $this->getBrands(),
        ]);
    }

    public function editProduct(Request $request)
    {
        $productId = (int)$request->product_id;
        $product = Product::with(['languages', 'categories', 'attributes', 'images'])->findOrFail($productId);
        foreach ($product->languages as $key => $language) {
            if ($language->id == 1) {
                $product->titleAr = $language->pivot->title;
                $product->descriptionAr = $language->pivot->long_description;
            }
            if ($language->id == 2) {
                $product->titleEn = $language->pivot->title;
                $product->descriptionEn = $language->pivot->long_description;
            }
        }
        if (count($product->categories) > 0) {
            foreach ($product->categories as $key => $category) {
                if ($key == 0) {
                    $product->category = $category->id;
                }
                if ($key == 1) {
                    $product->subcategory = $category->id;
                }
                if ($key == 2) {
                    $product->subsubcategory = $category->id;
                }
            }
        }
        $response = new ResponseBuilder(200, 'Tyre Data', ['product' => $product]);
        return $response->build();
    }

    public function update(ProductRequest $request, $id = 0)
    {
        $err = $this->save($request, $request->id);
        if ($request->id == 0) {
            $response = new ResponseBuilder(200, 'Tyre saved successfully.', []);
            return $response->build();
//            return ($err) ? $err : redirect(route('admin.products.index'))->with('status', 'Product Added ');
        } else {
            $cartData = Cart::where('product_id', $request->id)->get();
            $user_ids = $cartData->pluck('user_id');
            $productQuantity = $cartData->sum('quantity');
            $product = Product::find($request->id);
            $productQuantity = $product->quantity + $productQuantity;
            $product->update(['quantity' => $productQuantity]);
            if (count($user_ids) > 0) {
                foreach ($user_ids as $user_id) {
                    $notification = Notification::create([
                        'user_id' => $user_id,
                        'extras' => json_encode(['product_id' => $id]),
                        'type' => 'user'
                    ]);
                    /*   $notification->languages()->attach([2 => ['title' => 'Cart Changed', 'description' => 'price of a tyre in your cart has been changed'],
                           1 => ['title' => 'تغير السعر', 'description' => 'تم تغيير سعر المنتج في سلة التسوق الخاصة بك']]);*/

                    $notification->languages()->attach([2 => ['title' => 'Cart Changed', 'description' => 'price of a tyre in your cart has been changed'],
                        1 => ['title' => 'تغير السعر', 'description' => 'تغير سعر الإطار في عربة التسوق الخاصة بك']]);
                    event(new newNotifications('new notification', $user_id));
                    event(new CartChangeNotifications('cart', $user_id));
                }
                Cart::where('product_id', $id)->delete();
            }

            $response = new ResponseBuilder(200, 'Tyre saved successfully.', []);
            return $response->build();

        }
    }

    private function getViewParams($id = 0)
    {
        $locales = config('app.locales');
        $product = new Product();
        $translations = [];
        foreach ($locales as $shortCode => $languageId) {
            $translations[$languageId]['title'] = '';
            $translations[$languageId]['short_description'] = '';
            $translations[$languageId]['description'] = '';
        }
        if ($id > 0) {
//            $product = Product::with(['languages', 'categories','attributes','images'])->findOrFail($id);
            $product = Product::with(['languages', 'categories', 'attributes', 'images'])->findOrFail($id);
            $product->image1 = $product->image;
            if (count($product->images) > 0) {
                foreach ($product->images as $imagevalue) {
                    $productImages[] = $imagevalue->image;
                }
//                dd($productImages);
                $product->images = $productImages;
            }
//            dd($product);

            foreach ($locales as $shortCode => $languageId) {
                foreach ($product->languages as $key => $language) {
                    if ($language->id == $languageId) {
                        $translations[$languageId]['title'] = $language->pivot->title;
                        $translations[$languageId]['short_description'] = $language->pivot->short_description;
                        $translations[$languageId]['description'] = $language->pivot->long_description;
                    }
                }
            }
            if (count($product->categories) > 0) {
                foreach ($product->categories as $key => $category) {
                    if ($key == 0) {
                        $product->category_id = $category->id;
                    }
                    if ($key == 1) {
                        $product->subCategory_id = $category->id;
                    }
                    if ($key == 2) {
                        $product->version_id = $category->id;
                    }
                }
            }

            $selectedAttribute = [];
            $selectedSubAttribute = [];
            if (count($product->attributes) > 0) {
                foreach ($product->attributes as $key => $value) {
                    if ($value->pivot->parent_attribute_id == 0) {
                        $selectedAttribute[] = $value->pivot->attribute_id;
                    } else {
                        $selectedSubAttribute[] = $value->pivot->attribute_id;
                    }
                }
            }

            unset($product->attributes);

            $product->selectedAttributes = $selectedAttribute;
            $product->selectedSubAttributes = $selectedSubAttribute;
            if ($selectedAttribute) {
                $product->attributes = $this->getCategoryAttributes($product->category_id);
            } else {
                $product->attributes = [];
            }
            $product->subCategories = $this->getSubCategories($product->category_id);
            $product->versions = $this->getSubCategories($product->subCategory_id);

            unset($product->languages);
            unset($product->categories);
        }
//        $productImages = [];
//
//        $product->images = $productImages;

        $product->translations = $translations;
        return $product;
    }

    public function destroy($id)
    {
        $product = Product::where('id', '=', $id)->firstOrFail();
        $product->attributes()->detach();
        Product::destroy($id);
        Cart::where('product_id', $id)->delete();
        return response(['msg' => 'Tyre deleted.']);
    }

    public function productDetail($productId)
    {
        $this->breadcrumbs[route('admin.products.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage tyres'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Cart'];


        $product = Product::with(['carModel.languages', 'vehicle.languages', 'brand.languages', 'SpeedIndex.languages', 'labels.languages'])
            ->where('id', '=', $productId)
            ->firstOrFail();
        $product->translation = $this->translateRelation($product);
        $product->carModel->translation = $this->translateRelation($product->carModel);
        $product->vehicle->translation = $this->translateRelation($product->vehicle);
        $product->brand->translation = $this->translateRelation($product->brand);
        $product->speedIndex->translation = $this->translateRelation($product->speedIndex);
        $this->setTranslations($product->labels);
        $action = route('admin.cart.store');

        return view('admin.products.product-detail', ['product' => $product, 'action' => $action]);
    }

    public function check()
    {
        return view('admin.orders.test');
    }

    public function getSubCategories1($id)
    {
        $data['subCategories'] = $this->getSubCategories($id);
        $data['attribute'] = $this->getCategoryAttributes($id);
        return $data;
    }

    public function getSubAttributesAjax(Request $request)
    {
        $data['attributes'] = $this->getsubAttriutes($request->id);
        return $data;
    }

    public function incrementSlug($slug, $id)
    {

        $original = $slug;

        $count = 2;
        if ($id == 0) {
            while (Product::whereSlug($slug)->exists()) {

                $slug = "{$original}-" . $count++;
            }
        } else {
            while (Product::whereSlug($slug)->where('id', '!=', $id)->exists()) {

                $slug = "{$original}-" . $count++;
            }
        }


        return $slug;

    }

    public function getSubSubCategories1($id)
    {
        $data['subCategories'] = $this->getSubSubCategories($id);
        //   $data['attribute'] =  $this->getCategoryAttributes($id);
        return $data;
    }

}
