<?php

namespace App\Models;

use App\Traits\Translations;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    use CommonFunctions, Translations;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'parent_id','image','attribute_id'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];

    public function languages(){
        return $this->belongsToMany('App\Models\Language')->withPivot('name');
    }
    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }
    public function attributes(){
        return $this->belongsToMany(Attribute::class);
    }
    protected function getImageAttribute() {
        if (!empty($this->attributes['image'])){
            return url($this->attributes['image']);
        }
        return url('images/productDetail.png');
    }
    public function subCategories(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function findById($id){
        $category = Category::whereHas('languages')->with('languages')->where('id', $id)->get();
        $this->setTranslations($category);
        return $category->first();
    }

    public function findWithProducts($id){
        $categories = Category::where('id', $id)->with(['products'])->latest()->get();
        $this->setTranslations($categories, 'languages', ['products' => 'languages']);
        return $categories->first();
    }

    public function search($key, $parent_id){
        $languagesCheck = function ($query) use ($key) {
            $query->where('category_language.name', 'like', '%' . $key . '%');
        };

        $query = $this->with('languages')->withCount('products');
        $query->whereHas('languages', $languagesCheck);
        $data = $query->latest()->get();
        $this->setTranslations($data);
        return $data;
    }



}
