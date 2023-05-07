<?php

namespace App\Models;

use App\Traits\Translations;
use Illuminate\Database\Eloquent\Model;
use function Clue\StreamFilter\fun;

class Brand extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    use CommonFunctions, Translations;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'image', 'slug'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];


    public function languages(){
        return $this->belongsToMany('App\Models\Language')->withPivot('title');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageAttribute()
    {
        if (empty($this->attributes['image']))
        {
            return url('images/productDetail.png');
        }
        return url( $this->attributes['image']);
    }

    public function findWithProducts($id){
        $brands = $this->with(['products'])->where('id', $id )->latest()->get();
        $this->setTranslations($brands, 'languages', ['products'=>'languages']);
        return $brands->first();
    }

    public function search($key, $parent_id){
        $languagesCheck = function ($query) use ($key) {
            $query->where('brand_language.title', 'like', '%' . $key . '%');
        };

        $query = $this->with('languages')->withCount('products');
        $query->whereHas('languages', $languagesCheck);
        $data = $query->latest()->get();
        $this->setTranslations($data);
        return $data;
    }

    public function getBrands(){
        $brands = $this->all();
        $this->setTranslations($brands);
        return $brands;
    }

}
