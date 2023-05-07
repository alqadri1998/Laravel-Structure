<?php

namespace App\Http\Controllers\Front;

use App\Models\Attribute;
use App\Models\AttributeProduct;
use App\Models\Brand;
use App\Models\Origin;
use App\Models\Promotion;
use App\Traits\GetAttributes;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Collection;
use function Composer\Autoload\includeFile;
use function foo\func;

class ProductController extends Controller
{
    use GetAttributes;

    public $attribute;
    public $brand;
    public $origin;
    public $category;
    public $promotion;
    public $filterAttributesId = [];
    public $filterSubAttributesId = [];
    public $filteredProductsId = [];
    public $filteredBrandsId = [];
    public $filteredOriginsId = [];
    public $filteredVehiclesId = [];
    public $filteredPromotionsId = [];
    public $filteredYears = [];

    public function __construct(Attribute $attribute, Brand $brand, Origin $origin, Category $category, Promotion $promotion)
    {
        parent::__construct();
        $this->attribute = $attribute;
        $this->brand = $brand;
        $this->origin = $origin;
        $this->category = $category;
        $this->promotion = $promotion;
    }

    public function index(Request $request)
    {
//        dd($request->all());
        $this->breadcrumbTitle = 'Tyres';
        $this->breadcrumbs[route('front.product.index')] = ['title' => 'Tyres'];

        $query = Product::query();
        $sort = '';
        /*Set data so that the search functions can take over*/
        if ($request->has('search_model')) {
            if ($request->has('shop_by_size')) $request['attribute'] = $this->setData($request);
            if ($request->has('shop_by_vehicle')) $request['vehicle'] = $this->setData($request);

        }


//        dd($request->all());
//        If request has search in it that means it is a search call from filter page.
        if ($request->has('search')) {
            if ($request->has('attribute') || $request->has('width_back') || $request->has('height_back') || $request->has('rim_back') || $request->has('width') || $request->has('height') || $request->has('rim')) {
                if ($request->has('width_back') || $request->has('height_back') || $request->has('rim_back') || $request->has('width') || $request->has('height') || $request->has('rim')) {
                    $width = $request->input('width');
                    $height = $request->input('height');
                    $rim = $request->input('rim');

                    $width_back = $request->input('width_back');
                    $height_back = $request->input('height_back');
                    $rim_back = $request->input('rim_back');

                    $commonBackProduct = [];
                    if ($request->has('width_back')){

                    $widthBackProducts = [];
                    $heightBackProducts = [];
                    $rimBackProducts = [];

                    if ($request->has('width_back')){
                        $widthBackAttributes = AttributeProduct::where('attribute_id', $width_back)->get();
                    }else{
                        $widthBackAttributes = AttributeProduct::all();
                    }
                    if ($request->has('height_back')){
                        $heightBackAttributes = AttributeProduct::where('attribute_id', $height_back)->get();
                    }else{
                        $heightBackAttributes = AttributeProduct::all();
                    }
                    if ($request->has('rim_back')){
                        $rimBackAttributes = AttributeProduct::where('attribute_id', $rim_back)->get();
                    }else{
                        $rimBackAttributes = AttributeProduct::all();
                    }

                    foreach ($widthBackAttributes as $attribute) {
                        array_push($widthBackProducts, $attribute->product_id);
                    }
                    foreach ($heightBackAttributes as $attribute) {
                        array_push($heightBackProducts, $attribute->product_id);
                    }
                    foreach ($rimBackAttributes as $attribute) {
                        array_push($rimBackProducts, $attribute->product_id);
                    }
                    $commonBackProduct = array_intersect($widthBackProducts, $heightBackProducts, $rimBackProducts);
                    }

                    $widthProducts = [];
                    $heightProducts = [];
                    $rimProducts = [];
                    if ($request->has('width')){
                        $widthAttributes = AttributeProduct::where('attribute_id', $width)->get();
                    }else{
                        $widthAttributes = AttributeProduct::all();
                    }
                    if ($request->has('height')){
                        $heightAttributes = AttributeProduct::where('attribute_id', $height)->get();
                    }else{
                        $heightAttributes = AttributeProduct::all();
                    }
                    if ($request->has('rim')){
                        $rimAttributes = AttributeProduct::where('attribute_id', $rim)->get();
                    }else{
                        $rimAttributes = AttributeProduct::all();
                    }

                    foreach ($widthAttributes as $attribute) {
                        array_push($widthProducts, $attribute->product_id);
                    }
                    foreach ($heightAttributes as $attribute) {
                        array_push($heightProducts, $attribute->product_id);
                    }
                    foreach ($rimAttributes as $attribute) {
                        array_push($rimProducts, $attribute->product_id);
                    }
                    $commonProduct = array_intersect($widthProducts, $heightProducts,$rimProducts);

                    $productIds = array_merge($commonProduct, $commonBackProduct);

                    $query->whereIn('id', $productIds);

                } else {
//                    dd('not missed');
                    $attributeIds = [];
                    foreach ($request->attribute as $key => $value) {
                        array_push($attributeIds, $key);
                    }
                    $query->whereHas('attributes', function ($q) use ($attributeIds) {
                        $q->whereIn('attributes.id', $attributeIds);
                    }, '=', count($attributeIds));

                    $this->applyAttributeFilter($request->attribute);

                }


            }

            if ($request->has('brand')) {
                $brandIds = [];
                foreach ($request->brand as $key => $value) {
                    array_push($brandIds, $key);
                }
//                if (count($brandIds) > 1){
//                    $this->applyBrandFilter($request->brand);
//                    dd('yolo');
//                    $query->whereIn('brand_id',$this->filteredBrandsId);
//                }else{
                $query->whereHas('brand', function ($q) use ($brandIds) {
                    $q->whereIn('id', $brandIds);
                }, '=', count($brandIds));
                $this->applyBrandFilter($request->brand);
//                }
            }
            if ($request->has('origin')) {
                $originIds = [];
                foreach ($request->origin as $key => $value) {
                    array_push($originIds, $key);
                }
//                if (count($originIds) > 1){
//                    $this->applyOriginFilter($request->origin);
//                    $query->whereIn('origin_id',$this->filteredOriginsId);
//                }else{
                $query->whereHas('origin', function ($q) use ($originIds) {
                    $q->whereIn('origin_id', $originIds);
                }, '=', count($originIds));
                $this->applyOriginFilter($request->origin);
//                }

//                $this->applyOriginFilter($request->origin);
            }
            if ($request->has('vehicle')) {

//                Remove this to go back to old code
                $vehicleIds = [];
                foreach ($request->vehicle as $key => $value) {
                    array_push($vehicleIds, $key);
                }
//                dd($attributeIds);
                $query->whereHas('categories', function ($q) use ($vehicleIds) {
                    $q->whereIn('categories.id', $vehicleIds);
                }, '=', count($vehicleIds));

//                Old code logic
                $this->applyVehicleFilter($request->vehicle);
            }

            if ($request->has('promotion')) {

                $promotionIds = [];
                foreach ($request->promotion as $key => $value) {
                    array_push($promotionIds, $key);
                }
//                if (count($promotionIds) > 1){
//                    $this->applyOriginFilter($request->promotion);
//                    $query->whereIn('promotion_id',$this->filteredPromotionsId);
//                }else{
                $query->whereHas('promotion', function ($q) use ($promotionIds) {
                    $q->whereIn('promotion_id', $promotionIds);
                }, '=', count($promotionIds));
                $this->applyPromotionFilter($request->promotion);
//                }

//                $this->applyPromotionFilter($request->promotion);
            }
            if ($request->sort == 'price_low_to_high') {
                $query->orderBy('price', 'asc');
                $sort = $request->sort;
            } else if ($request->sort == 'price_high_low') {
                $query->orderBy('price', 'desc');
                $sort = $request->sort;
            }

            if ($request->has('year')){
                if (!is_array($request->year)){
                    $query->where('year', $request->year);
                }else{
                    foreach ($request->year as $key => $value){
                        $query->where('year', $key);
                    }
                }

                $this->applyYearFilter($request->year);
            }

//            $this->removeDuplicateId();

//            $products = Product::whereHas('languages')->whereHas('categories')->whereIn('id',$this->filteredProductsId)->with('languages', 'attributes', 'origin', 'brand', 'promotion')->latest()->paginate(6);

            $products = $query->whereHas('languages')->whereHas('categories')->whereHas('brand')->with('languages', 'attributes', 'origin', 'brand', 'promotion')->latest()->paginate(6);
            $this->setTranslations($products, 'languages', ['attributes' => 'languages', 'origin' => 'languages', 'brand' => 'languages', 'promotion' => 'languages']);

        } else {
            $products = $query->whereHas('languages')->whereHas('categories')->whereHas('brand')->with('languages', 'attributes', 'origin', 'brand')->latest()->paginate(6);
            $this->setTranslations($products, 'languages', ['attributes' => 'languages', 'origin' => 'languages', 'brand' => 'languages', 'promotion' => 'languages']);
        }


        /*Model Queries*/
        foreach ($products as $product) {
            $attributes = $this->getAttributes($product->attributes);
            $product->subAttributes = $attributes;
        }
        $years = $this->getYearsFilter();

        $attributes = Attribute::whereHas('languages')->with(['languages', 'subAttributes' => function ($subAttributes) {
            $subAttributes->whereHas('languages')->with(['languages'])->withCount('products');
        }])->where('parent_id', 0)->latest()->get();
        $this->setTranslations($attributes, 'languages', ['subAttributes' => 'languages']);

        $brands = Brand::whereHas('languages')->with('languages')->withCount('products')->latest()->get();
        $this->setTranslations($brands);

        $origins = Origin::whereHas('languages')->with('languages')->withCount('products')->latest()->get();
        $this->setTranslations($origins);

        $categories = Category::whereHas('languages')->with(['languages'])->withCount('products')->where('parent_id', 0)->latest()->get();
        $this->setTranslations($categories, 'languages');

        $promotions = $this->promotion->getWithProductCount();
//        dd($categories);
//        dd( $request->input('width'), $request->input('height'));
//        return $products;
        return view('front.products.list', [
            'products' => $products,
            'attributes' => $attributes,
            'brands' => $brands,
            'origins' => $origins,
            'tyreCategories' => $categories,
            'promotions' => $promotions,
            'years' => $years,
            'filterAttributesId' => $this->filterAttributesId,
            'filterSubAttributesId' => $this->filterSubAttributesId,
            'filteredBrandsId' => $this->filteredBrandsId,
            'filteredOriginsId' => $this->filteredOriginsId,
            'filteredVehiclesId' => $this->filteredVehiclesId,
            'filteredPromotionsId' => $this->filteredPromotionsId,
            'filteredYears' => $this->filteredYears,
            'sort' => $sort,
            'tyre_width' => $request->input('width'),
            'tyre_height' => $request->input('height'),
            'rim' => $request->input('rim'),
            'width_back' => $request->input('width_back'),
            'height_back' => $request->input('height_back'),
            'rim_back' => $request->input('rim_back'),
        ]);
    }

    public function getYearsFilter(){
        $products = Product::all();
        $productsYear = [];
        $years = [];
        foreach ($products as $product){
            array_push($productsYear, $product->year);
        }

        $productsYear = array_filter($productsYear);
        $productsYear = array_unique($productsYear);
        foreach ($productsYear as $productYear){
            $yearCount = Product::where('year',$productYear)->count();
            $temp = new \stdClass();
            $temp->year = $productYear;
            $temp->count = $yearCount;
            array_push($years,$temp);
        }

        return $years;
    }

    public function detail($slug)
    {

        $favorites = function ($favorites) {
            if (auth()->user()) {
                $favorites->where('user_id', auth()->user()->id);
            }
        };
        $images = function ($images) {
            $images->orderby('default_image', 'DESC');
        };

        $product = Product::whereHas('languages')->with(['languages', 'images' => $images, 'categories', 'attributes' => function ($query) {
            $query->whereHas('languages')->with('languages');
        }, 'favorites' => $favorites, 'origin'])->where('slug', $slug)->get();
//        $product->translation = $this->translateRelation($product);
        $this->setTranslations($product, 'languages', ['categories' => 'languages', 'attributes' => 'languages', 'origin' => 'languages']);
        $product = $product->first();

//        if (count($product->categories) > 0) {
//            $this->setTranslations($product->categories);
//        }
//        if (count($product->attributes) > 0) {
//            $this->setTranslations($product->attributes);
//        }
        $product->is_favourite = false;

        if (count($product->favorites) > 0) {
            $product->is_favourite = true;
        }
        $attributes = [];
        $parentIds = [];
//        dd($product->toArray());
        $product['default_image'] = $product->image;
        $loop = 0;
        foreach ($product->attributes->toArray() as $attribute) {
            if ($attribute['parent_id'] == 0) {
                $attributes[] = $attribute;
                $parentIds[] = $attribute['id'];
            }

        }
        foreach ($product->attributes->toArray() as $attribute) {
            if ($attribute['parent_id'] != 0) {
                $attributeIndex = array_search($attribute['parent_id'], $parentIds);
                if ($attributeIndex >= 0) {
                    if ($product->images_dependent == true) {
                        if ($attribute['pivot']['images']) {
                            $attribute['images'] = json_decode($attribute['pivot']['images']);
                            $attribute['images'] = Arr::sort($attribute['images'], function ($student) {
                                // Sort the student's scores by their test score.
                                return !$student->isDefault;
                            });
                            foreach ($attribute['images'] as $image) {
                                if ($image->isDefault == true) {
                                    if ($loop == 0) {
                                        \Log::info($loop);
                                        $product['default_image'] = $image->image;
                                        $loop = $loop + 1;
                                    }
                                    $attribute['default_image'] = $image->image;

                                    break;
                                }

                            }
                        } else {
                            $attribute['images'] = [];
                            $attribute['default_image'] = $product->image;
                        }
                    } else {
                        $attribute['images'] = [];
                        $attribute['default_image'] = $product->image;
                    }
                    $attributes[$attributeIndex]['subAttributes'][] = $attribute;

                }
            }

        }

        unset($product->languages, $product->favorites, $product->attributes);
        $this->breadcrumbTitle = $product->translation->title;
        $this->breadcrumbs['javascript: {};'] = ['title' => $product->translation->title];
        return view('front.products.detail', ['product' => $product, 'attributes' => $attributes]);
    }

    /**
     * Get all the attributes of the product, divide them into attributes and subattributes, and only send back the subattributes which are featured.
     * Only return array of attribute's name and subattribute's name
     * @param $attributes
     * @return array
     */
    public function getAttributes($attributes)
    {
        $featured = [];
        $tempArray = [];
        foreach ($attributes as $attribute) {
            if ($attribute->is_featured == 1) {
                array_push($featured, $attribute);
            }
        }
        foreach ($featured as $attribute) {
            foreach ($attributes as $subAttribute) {
                if ($subAttribute->parent_id == $attribute->id) {
                    $attribute['subAttribute'] = $subAttribute;
                }
            }
        }
//        return response($featured)->throwResponse();
//        dd($featured);
        foreach ($featured as $attribute) {
//            var_dump($attribute->translation->name);
            $temp = new \stdClass();
            $temp->name = $attribute->translation->name;
            $temp->value = isset($attribute->subAttribute) ? $attribute->subAttribute->translation->name : '';
            array_push($tempArray, $temp);
        }
        return $tempArray;

    }

    public function applyAttributeFilter($attributes)
    {
        foreach ($attributes as $attributeId => $value) {
            $attribute = $this->attribute->findWithProducts($attributeId);
            if (!is_null($attribute)) {
                foreach ($attribute->products as $product) {

                    array_push($this->filteredProductsId, $product->id);
                }

                array_push($this->filterSubAttributesId, $attribute->id);
                array_push($this->filterAttributesId, $attribute->parent_id);
            }

        }
    }

    public function applyBrandFilter($brands)
    {
        foreach ($brands as $brandId => $value) {
            $brand = $this->brand->findWithProducts($brandId);

            foreach ($brand->products as $product) {
                array_push($this->filteredProductsId, $product->id);
            }
            array_push($this->filteredBrandsId, $brand->id);
        }
    }

    public function applyYearFilter($years)
    {
        if (!is_array($years)){
            array_push($this->filteredYears, $years);
        }else{
            foreach ($years as $year => $value) {
                array_push($this->filteredYears, $year);
            }
        }

    }

    public function applyOriginFilter($origins)
    {
        foreach ($origins as $originId => $value) {
            $origin = $this->origin->findWithProducts($originId);
            foreach ($origin->products as $product) {
                array_push($this->filteredProductsId, $product->id);
            }
            array_push($this->filteredOriginsId, $origin->id);
        }
    }

    public function applyVehicleFilter($vehicles)
    {
        foreach ($vehicles as $vehicleId => $value) {
            $vehicle = $this->category->findWithProducts($vehicleId);
            foreach ($vehicle->products as $product) {
                array_push($this->filteredProductsId, $product->id);
            }
            array_push($this->filteredVehiclesId, $vehicle->id);

        }
    }

    public function applyPromotionFilter($promotions)
    {
        foreach ($promotions as $promotionId => $value) {
            $promotion = $this->promotion->findWithProducts($promotionId);
            foreach ($promotion->products as $product) {
                array_push($this->filteredProductsId, $product->id);
            }
            array_push($this->filteredPromotionsId, $promotion->id);
        }
    }

    public function removeDuplicateId()
    {
        $this->filteredProductsId = collect($this->filteredProductsId)->unique();
    }

    public function setData($request)
    {
        if ($request->has('shop_by_size')) {
            $attribute = [];
            if ($request->has('width')) $attribute[$request->width] = 'on';
            if ($request->has('height')) $attribute[$request->height] = 'on';
            if ($request->has('rim')) $attribute[$request->rim] = 'on';
            if ($request->has('width_back')) $attribute[$request->width_back] = 'on';
            if ($request->has('height_back')) $attribute[$request->height_back] = 'on';
            if ($request->has('rim_back')) $attribute[$request->rim_back] = 'on';
            return $attribute;
        }
        if ($request->has('shop_by_vehicle')) {
            $vehicle = [];
            if ($request->has('vehicle')) $vehicle[$request->vehicle] = 'on';
            return $vehicle;

        }
    }

}
