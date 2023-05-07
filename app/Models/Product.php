<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 16 Jan 2019 13:38:38 +0000.
 */

namespace App\Models;

use App\Traits\Translations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use function Clue\StreamFilter\fun;
use function foo\func;

/**
 * Class Product
 *
 * @property int $id
 * @property int $brand_id
 * @property int $delivery_type_id
 * @property int $speed_index_id
 * @property int $car_model_id
 * @property int $vehicle_id
 * @property string $season
 * @property string $load_index
 * @property string $slug
 * @property int $price
 * @property string $item_code
 * @property int $quantity
 * @property string $image
 * @property string $tire_type
 * @property string $ean
 * @property string $snowflake_quality
 * @property string $bar_code
 * @property string $dot
 * @property string $article
 * @property float $discount
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 * @property float $value_added_tax
 * @property float $dg
 * @property string $size
 *
 * @property \Illuminate\Database\Eloquent\Collection $languages
 * @property \Illuminate\Database\Eloquent\Collection $orderDetails
 * @property \Illuminate\Database\Eloquent\Collection $labels
 *
 * @package App\Models
 */
class Product extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions, Translations;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $casts = [
        'price' => 'float',
        'quantity' => 'int',
        'discount' => 'float',
        'created_at' => 'int',
        'updated_at' => 'int',
        'value_added_tax' => 'float',
        'dg' => 'float'
    ];

    protected $fillable = [
        'slug',
        'price',
        'quantity',
        'image',
        'discount',
        'discount_percent',
        'offer',
        'vat',
        'images_dependent',
        'type',
        'brand_id',
        'origin_id',
        'year',
        'promotion_id',
        'sku'
    ];

    public function languages()
    {
        return $this->belongsToMany(\App\Models\Language::class)
            ->withPivot('title', 'short_description', 'long_description', 'performance');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(\App\Models\OrderDetail::class);
    }

    public function getImageAttribute()
    {
        if (empty($this->attributes['image'])) {
            return 'images/productDetail.png';
        }
        if (str_contains($this->attributes['image'],'http')){
            return $this->attributes['image'];

        }
            return url($this->attributes['image']);

    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('parent_attribute_id', 'images_dependent', 'images');
    }

    public function attributeProducts()
    {
        return $this->hasMany(AttributeProduct::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites_product');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public static function search($request)
    {
        $languagesCheck = function ($query) use ($request) {
            if ($request->keyword) {
                $query->where('language_product.title', 'like', '%' . $request->keyword . '%');
            }
        };
        $categoryCheck = function ($query) use ($request) {
            $query->where('category_id', $request->category);
        };
        $subCategoryCheck = function ($query) use ($request) {
            $query->where('category_id', $request->category);
        };
        $favorites = function ($favorites) {
            $favorites->where('user_id', auth()->user()->id);
        };
        if (auth()->user()) {
            $relations = ['languages', 'favorites' => $favorites];
        } else {
            $relations = ['languages'];
        }
        $query = Product::with($relations);
        if ($request->keyword) {
            $query->whereHas('languages', $languagesCheck);
        }
        if ($request->category) {
            $query->whereHas('categories', $categoryCheck);
        }
        if ($request->sub_category) {
            $categoriesArray = [$request->category, $request->sub_category];
            $query->whereHas('categories', function ($q) use ($categoriesArray) {
                $q->whereIn('id', $categoriesArray);
            }, '=', count($categoriesArray));
            // $query->whereHas('categories',$subCategoryCheck);
        }
        if ($request->subcategory_3) {
            $categoriesArray = [$request->category, $request->sub_category, $request->subcategory_3];
            $query->whereHas('categories', function ($q) use ($categoriesArray) {
                $q->whereIn('id', $categoriesArray);
            }, '=', count($categoriesArray));
//            $query->whereHas('categories',$subCategoryCheck);
        }

        if ($request->price_range) {
            $price_range = explode(';', $request->price_range);
            $currencyId = session('CURRENCY_ID', config('app.currencies.USD'));
            if ($currencyId == 2) {
                $price_range[0] = getUsdAedPrice($price_range[0]);
                $price_range[1] = getUsdAedPrice($price_range[1]);
            }

            $query->whereBetween('discount', [$price_range[0], $price_range[1]]);
        }
        $data = $query->orderBY('created_at', 'DESC')->paginate(9);
        return $data;

    }

    public function getServicePackages()
    {
        $servicePackages = Product::whereHas('languages')->where('type', 'package')->latest()->paginate(6);
        $this->setTranslations($servicePackages);
        return $servicePackages;
    }

    public function yearSearch($key)
    {
        $products = $this->all();
        $productsYear = [];
        $years = [];
        foreach ($products as $product) {
            array_push($productsYear, $product->year);
        }
        $productsYear = array_filter($productsYear);
        $productsYear = array_unique($productsYear);
        $input = preg_quote($key, '~'); // don't forget to quote input string!
        $results = preg_grep('~' . $input . '~', $productsYear);

        foreach ($results as $productYear) {
            $yearCount = Product::where('year', $productYear)->count();
            $temp = new \stdClass();
            $temp->year = $productYear;
            $temp->count = $yearCount;
            array_push($years, $temp);
        }

        return $years;
    }


}
