<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Origin;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ExcelController extends Controller
{
    public $branch;
    public $category;
    public $product;
    public $brand;
    public $promotion;
    public $attribute;

    public $brands = [];
    public $origins = [];
    public $allProperties = [];
    public $attributes = [];
    public $categories = [];
    public $promotions = [];

    public function __construct(Branch $branch, Category $category, Product $product, Brand $brand, Promotion $promotion, Attribute $attribute)
    {
        parent::__construct();
        $this->branch = $branch;
        $this->category = $category;
        $this->product = $product;
        $this->brand = $brand;
        $this->promotion = $promotion;
        $this->attribute = $attribute;
    }

    public function importExcelData(Request $request)
    {
        try {
       $extension = request()->file('excel_import')->getClientOriginalExtension();
        if ($extension != 'xlsx'){
            return redirect(route('admin.products.index'))->with('err', 'Only .xlsx extension files are allowed.');
        }
        HeadingRowFormatter::default('none');
        $excelData = Excel::ToArray(new ProductsImport(), request()->file('excel_import'));
        $data = $this->getAttributes();
        $this->allProperties = $data['properties'];
        $this->attributes = $data['attributes'];
        $this->brands = $this->setBrands();
        $this->origins = $this->setOrigins();
        $this->categories = $this->setCategories();
        $this->promotions = $this->setPromotions();
        $productsToBeCreated = [];
        $slugCount = 1;
        foreach (array_flatten($excelData, 1) as $data) {
            $temp = new \stdClass();
            $temp->titleEn = isset($data['TITLE']) ? $data['TITLE'] : 'New Product';
            $temp->slug = str_slug($temp->titleEn) . $slugCount;
            $temp->description = isset($data['DESCRIPTION']) ? $data['DESCRIPTION'] : 'New Product Description';
            $temp->image = $data['PRODUCT_IMAGE'];
            $temp->price = isset($data['PRICE'])? $data['PRICE'] : 0;
            $temp->year = isset($data['YEAR'])? $data['YEAR']: '';
            $temp->sku = isset($data['SKU'])? $data['SKU']: '';
            $temp->vat = 0;
            $temp->quantity = isset($data['QUANTITY'])? $data['QUANTITY'] : 0;
            $temp->offer = is_null($data['DISCOUNT_PERCENTAGE']) ? 0 : 1;
            $temp->discount = isset($data['DISCOUNT_PERCENTAGE']) && !is_null($data['DISCOUNT_PERCENTAGE']) ? $data['PRICE'] - ($data['PRICE'] * $data['DISCOUNT_PERCENTAGE'] / 100) : 0;
            $temp->discount_percent = isset($data['DISCOUNT_PERCENTAGE']) && !is_null($data['DISCOUNT_PERCENTAGE']) ? $data['DISCOUNT_PERCENTAGE'] : 0  /*(($data['actual price'] - $data['discount price']) / $data['actual price']) * 100*/
            ;
            $temp->category_id = $this->getCategoryId($data['VEHICLE']);
            $temp->subcategory_id = $this->getCategoryId($data['MODEL'], $temp->category_id);
            $temp->brand_id = isset($data['BRANDS']) ? $this->getBrandId($data['BRANDS'],$data['BRAND_IMAGE'] ) : null;
            $temp->origin_id = isset($data['ORIGIN']) ? $this->getOriginId($data['ORIGIN']) : null;
            $temp->promotion_id = isset($data['PROMOTION']) ? $this->getPromotionId($data['PROMOTION']) : null;

            $temp->attributes = $this->getAttributeIds($data);

            array_push($productsToBeCreated, $temp);
            $slugCount++;
        }
        foreach ($productsToBeCreated as $product) {
            $id = 0;
            $newProduct = '';
            $objectToArray = json_decode(json_encode($product), true);
            $newProduct = Product::updateOrCreate(['id' => $id], $objectToArray);
            $newProduct->languages()->syncWithoutDetaching([
                2 => [
                    'title' => $product->titleEn,
                    'long_description' => $product->description,
                ],
            ]);

            ProductImage::insert(['product_id' => $newProduct->id, "image" => $product->image, 'default_image' => 1]);

            $newProduct->categories()->sync([$objectToArray['category_id'], $objectToArray['subcategory_id']]);
            foreach ($product->attributes as $attribute) {
                $newProduct->attributes()->syncWithoutDetaching([
                    $attribute->parent_id => [
                        'parent_attribute_id' => 0,
                        'images_dependent' => 0,
                        'images' => null
                    ]]);

                $newProduct->attributes()->syncWithoutDetaching([
                    $attribute->id => [
                        'parent_attribute_id' => $attribute->parent_id,
                        'images_dependent' => $attribute->images_dependent,
                        'images' => $attribute->images
                    ]]);
            }


        }
        return redirect(route('admin.products.index'))->with('status', 'Excel file imported successfully.');

        }catch (\Exception $e){
            return redirect(route('admin.products.index'))->with('err', 'Something went wrong');

        }
    }

    public function getAttributes()
    {
        $properties = [];
        $attributes = [];
        $data = $this->setTranslations($this->attribute->all());

        foreach ($data as $attribute) {
            $temp = new \stdClass();
            $temp->id = $attribute->id;
            $temp->parent_id = $attribute->parent_id;
            $temp->name = $attribute->translation->name;
            array_push($properties, $temp);
            if ($attribute->parent_id == 0) {
                $temp2 = new \stdClass();
                $temp2->id = $attribute->id;
                $temp2->parent_id = $attribute->parent_id;
                $temp2->name = $attribute->translation->name;
                array_push($attributes, $temp2);
            }
        }
        return compact('properties', 'attributes');
    }

    public function getBrandId($brandName, $image = null)
    {
        foreach ($this->brands as $brand) {
            if ($brand->slug == str_slug($brandName)) {
                return $brand->id;
            }
        }

        $id = 0;
        $newBrand = $this->brand->updateOrCreate(['id' => $id], [
            'slug' => str_slug($brandName),
            'image'=> $image
        ]);

        $newBrand->languages()->syncWithoutDetaching([
            2 => [
                'title' => $brandName,
            ],
        ]);
        $translatedBrands = $this->setTranslations([$newBrand]);

        array_push($this->brands, $translatedBrands[0]);

        return $newBrand->id;
    }

    public function getOriginId($originName)
    {
        foreach ($this->origins as $origin) {
            if ($origin->slug == str_slug($originName)) {
                return $origin->id;
            }
        }
        $id = 0;
        $newOrigin = Origin::updateOrCreate(['id' => $id], [
            'slug' => str_slug($originName),
        ]);

        $newOrigin->languages()->syncWithoutDetaching([
            2 => [
                'title' => $originName,
            ],
        ]);

        $translatedOrigins = $this->setTranslations([$newOrigin]);

        array_push($this->origins, $translatedOrigins[0]);
        return $newOrigin->id;
    }

    public function getPromotionId($promotionName)
    {
        foreach ($this->promotions as $promotion) {
            if ($promotion->slug == str_slug($promotionName)) {
                return $promotion->id;
            }
        }
        $id = 0;
        $newPromotion = Promotion::updateOrCreate(['id' => $id], [
            'slug' => str_slug($promotionName),
        ]);

        $newPromotion->languages()->syncWithoutDetaching([
            2 => [
                'title' => $promotionName,
            ],
        ]);

        $translatedPromotions = $this->setTranslations([$newPromotion]);

        array_push($this->promotions, $translatedPromotions[0]);
        return $newPromotion->id;
    }

    public function getCategoryId($categoryName, $parent_id = 0)
    {
        foreach ($this->categories as $category) {
            if ($category->parent_id == $parent_id) {
                if (strtolower($category->translation->name) == strtolower($categoryName)) {
                    return $category->id;
                }
            }
        }
        $id = 0;
        $newCategory = Category::updateOrCreate(['id' => $id], [
            'parent_id' => $parent_id,
        ]);

        $newCategory->languages()->syncWithoutDetaching([
            2 => [
                'name' => $categoryName,
            ],
        ]);
        if ($parent_id == 0) {
            $attributeIds = [];
            foreach ($this->attributes as $attribute) {
                array_push($attributeIds,$attribute->id);
            }
            $newCategory->attributes()->sync($attributeIds);
        }

        $translatedCategories = $this->setTranslations([$newCategory]);

        array_push($this->categories, $translatedCategories[0]);
        return $newCategory->id;
    }

    public function getAttributeIds($data)
    {
        $productProperties = [];
        if (isset($data['WIDTH']) && !empty($data['WIDTH'])) {
            $productAttribute = $this->getProductAttributeObject('width', $data['WIDTH']);
            array_push($productProperties, $productAttribute);
        }
        if (isset($data['HEIGHT']) && !empty($data['HEIGHT'])) {
            $productAttribute = $this->getProductAttributeObject('height', $data['HEIGHT']);
            array_push($productProperties, $productAttribute);
        }
        if (isset($data['RIM']) && !empty($data['RIM'])) {
//            if($data['SKU'] == 20282 ){
//                $productAttribute = $this->getProductAttributeObject1('rim', 'R'.$data['RIM']);
//            }
            $productAttribute = $this->getProductAttributeObject('rim', 'R' . $data['RIM']);
            array_push($productProperties, $productAttribute);
        }
        if (isset($data['PATTERN']) && !empty($data['PATTERN'])) {
            $productAttribute = $this->getProductAttributeObject('pattern', $data['PATTERN']);
            array_push($productProperties, $productAttribute);
        }

        if (isset($data['LOAD/SPEED_INDEX']) && !empty($data['LOAD/SPEED_INDEX'])) {
            $productAttribute = $this->getProductAttributeObject('Load/Speed Index', $data['LOAD/SPEED_INDEX']);
            array_push($productProperties, $productAttribute);
        }

        if (isset($data['WARRENTY_PERIOD']) && !empty($data['WARRENTY_PERIOD'])) {
            if ($data['WARRENTY_PERIOD'] > 1) {
                $warranty = $data['WARRENTY_PERIOD'] . ' Years Warranty';
            } else {
                $warranty = $data['WARRENTY_PERIOD'] . ' Year Warranty';
            }

            $productAttribute = $this->getProductAttributeObject('Warranty Period', $warranty);
            array_push($productProperties, $productAttribute);
        }

        $runFlat = 'no';
        if (isset($data['RUN_FLAT']) && !empty($data['RUN_FLAT'])) {
            $runFlat = 'yes';
        }
        $productAttribute = $this->getProductAttributeObject('Run Flat', $runFlat);
        array_push($productProperties, $productAttribute);

        return $productProperties;


    }

    public function getAttributeId($name)
    {
        foreach ($this->attributes as $attribute) {
            if (strtolower($attribute->name) == strtolower($name)) {
                return $attribute->id;
            };
        }
    }

    public function getProductAttributeObject($arrayName, $value)
    {
        $productProperty = [];
        $parent_id = $this->getAttributeId($arrayName);
        foreach ($this->allProperties as $property) {
            if ($property->parent_id == $parent_id) {
                if (strtolower($property->name) == strtolower($value)) {
                    $temp = new \stdClass();
                    $temp->id = $property->id;
                    $temp->parent_id = $property->parent_id;
                    $temp->images_dependent = false;
                    $temp->images = null;
                    array_push($productProperty, $temp);
                }
            }
        }
        if (count($productProperty) == 0) {
            $id = 0;
            $newAttribute = Attribute::updateOrCreate(['id' => $id], [
                'parent_id' => $parent_id,
                'is_featured' => 0,
                'image' => null,
            ]);
            $newAttribute->languages()->syncWithoutDetaching([
                2 => [
                    'name' => $value,
                ],
            ]);
            $attribute = $this->setTranslations([$newAttribute]);
            $temp = new \stdClass();
            $temp->id = $attribute[0]->id;
            $temp->parent_id = $attribute[0]->parent_id;
            $temp->name = $attribute[0]->translation->name;
            array_push($this->allProperties, $temp);

            $temp2 = new \stdClass();
            $temp2->id = $attribute[0]->id;
            $temp2->parent_id = $attribute[0]->parent_id;
            $temp2->images_dependent = false;
            $temp2->images = null;
            array_push($productProperty, $temp2);
        }

        return $productProperty[0];

    }


    public function setBrands()
    {
        $brandArray = [];
        $brands = $this->setTranslations($this->brand->all());
        foreach ($brands as $brand) {
            array_push($brandArray, $brand);
        }
        return $brandArray;
    }

    public function setOrigins()
    {
        $brandArray = [];
        $brands = $this->setTranslations(Origin::all());
        foreach ($brands as $brand) {
            array_push($brandArray, $brand);
        }
        return $brandArray;


    }

    public function setPromotions()
    {
        $promotionArray = [];
        $promotions = $this->setTranslations(Promotion::all());
        foreach ($promotions as $promotion) {
            array_push($promotionArray, $promotion);
        }
        return $promotionArray;


    }

    public function setCategories()
    {
        $categoryArray = [];
        $categories = $this->setTranslations(Category::all());
        foreach ($categories as $category) {
            array_push($categoryArray, $category);
        }
        return $categoryArray;


    }
}
