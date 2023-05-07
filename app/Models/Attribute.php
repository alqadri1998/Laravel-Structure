<?php

namespace App\Models;

use App\Traits\Translations;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use \App\Models\CommonModelFunctions;
    use CommonFunctions;
    use Translations;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'parent_id',
        'is_featured',
        'image'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];


    public function languages(){

//        return $this->hasMany(AttributeLanguage::class);
        return $this->belongsToMany(Language::class, 'attribute_language')->withPivot('name');
    }
    public function subAttributes(){
        return $this->hasMany(static::class, 'parent_id');
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function attribute(){
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function findWithProducts($id){
        $attributes = Attribute::whereHas('languages')->with(['languages', 'products' => function ($products) {
            $products->whereHas('languages')->with(['languages']);
        }])->where('id', $id)->latest()->get();
        $this->setTranslations($attributes, 'languages', ['products' => 'languages']);
        return $attributes->first();
    }

    public function search($key, $parent_id){
        $languagesCheck = function ($query) use ($key) {
                $query->where('attribute_language.name', 'like', '%' . $key . '%');
        };

        $query = $this->with('languages')->where('parent_id', $parent_id)->withCount('products');
        $query->whereHas('languages', $languagesCheck);
        $data = $query->latest()->get();
        $this->setTranslations($data);
        return $data;
    }
}
