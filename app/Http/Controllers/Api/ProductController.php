<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Libraries\ResponseBuilder;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Origin;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Traits\GetAttributes;


class ProductController extends Controller
{
    use GetAttributes;

    public $attribute;
    public $brand;
    public $origin;
    public $category;
    public $promotion;
    public $product;
    public $cart;

    public function __construct(Attribute $attribute, Brand $brand, Origin $origin, Category $category, Promotion $promotion, Product $product, Cart $cart)
    {
        parent::__construct();
        $this->attribute = $attribute;
        $this->brand = $brand;
        $this->origin = $origin;
        $this->category = $category;
        $this->promotion = $promotion;
        $this->product = $product;
        $this->cart = $cart;
    }

    public function categories()
    {
        $user = \JWTAuth::user();

        $subcategories = function ($subCategories) {
            $subCategories->whereHas('languages')->with(['languages', 'subCategories' => function ($query) {
                $query->whereHas('languages')->with('languages');
            }]);
        };
        $attributes = function ($subCategories) {
            $subCategories->whereHas('languages')->with(['languages', 'subAttributes' => function ($query) {
                $query->whereHas('languages')->with('languages');
            }]);
        };
        $categories = Category::whereHas('languages')->with(['languages', 'attributes' => $attributes, 'subCategories' => $subcategories])->where('parent_id', 0)->orderBy('created_at', 'DESC')->get();
        $this->setTranslations($categories, 'languages', ['subCategories' => 'languages', 'attributes' => 'languages']);

        unset($categories->languages);
        foreach ($categories as $key => $value) {
            foreach ($value->subCategories as $modelKey => $model) {
                if (count($model->subCategories) > 0) {
                    $this->setTranslations($model->subCategories);
                    unset($model->subCategories->languages);
                }

            }
            foreach ($value->attributes as $modelKey => $model) {
                if (count($model->subAttributes) > 0) {
                    $this->setTranslations($model->subAttributes);
                    unset($model->subAttributes->languages);
                }

            }
        }
        $response = new ResponseBuilder(200, 'Notifications', $categories);
        return $response->build();
    }

    public function brands()
    {
        $brands = Brand::whereHas('languages')->with(['languages'])->latest()->get();
        $this->setTranslations($brands);
        $response = new ResponseBuilder(200, 'Brands', $brands);
        return $response->build();
    }

    public function origin()
    {
        $origin = Origin::whereHas('languages')->with(['languages'])->latest()->get();
        $this->setTranslations($origin);
        $response = new ResponseBuilder(200, 'origin', $origin);
        return $response->build();
    }

    public function getFilters(Request $request){
        $value = $request->value;
        $type = $request->type;
        $parent = $request->parent;

        if ($type == 'attribute'){
            return $this->attribute->search($value,$parent);
        }
        if ($type == 'brand'){
            return $this->brand->search($value,$parent);
        }
        if ($type == 'origin'){
            return $this->origin->search($value,$parent);
        }
        if ($type == 'vehicle'){
            return $this->category->search($value,$parent);
        }
        if ($type == 'promotion'){
            return $this->promotion->search($value,$parent);
        }
        if ($type == 'year'){
            return $this->product->yearSearch($value);
        }


        dd($value,$type);
    }

    public function promotions()
    {
        $promotion = $this->promotion->getPromotions();
        $response = new ResponseBuilder(200, 'promotions', $promotion);
        return $response->build();
    }

    public function getWidthHeight($attribute_id){
      $attribute = $this->attribute->findWithProducts($attribute_id);
        $attributes = $this->getSubAttributes($attribute, 'height');
        return array_values($attributes->toArray());

    }

    public function getHeightRim($height_id){
        $attribute = $this->attribute->findWithProducts($height_id);
        $attributes = $this->getSubAttributes($attribute, 'rim');
        return array_values($attributes->toArray());
    }

    public function getSubAttributes($attribute, $name){
        $product_id = [];
        $productWithAttributes = [];
        $heightAttribute = [];
        $heightSubAttributes = [];

        foreach ($attribute->products as $product){
            array_push($product_id, $product->id);
        }
        foreach ($product_id as $id){
            $products = Product::whereHas('languages')->with(['languages', 'attributes'])->where('id', $id)->get();
            $this->setTranslations($products, 'languages', ['attributes'=>'languages']);
            array_push($productWithAttributes, $products->first());
        }

        foreach ($productWithAttributes as $product){
            foreach ($product->attributes as $attribute){
                if (strtolower($attribute->translation->name) == strtolower($name)){
                    array_push($heightAttribute, $attribute);
                }
            }
        }
        if (count($heightAttribute) > 0){
            foreach ($productWithAttributes as $product){
                foreach ($product->attributes as $attribute){
                    if ($attribute->parent_id == reset($heightAttribute)->id){
                        array_push($heightSubAttributes, $attribute);
                    }
                }
            }
        }
        return $this->removeDuplicates($heightSubAttributes);
    }

    public function removeDuplicates($array){

        return collect($array)->unique('id');
    }

    public function cartCount($id){
        $cart['count'] = $this->cart->cartCount($id);
        $response = new ResponseBuilder(200, 'Cart count', $cart);
        return $response->build();
    }


}