<?php

namespace App\Models;

use App\Traits\Translations;
use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    use CommonFunctions, Translations;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'slug'
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

    public function findWithProducts($id){
        $origins = Origin::where('id',$id)->with('products')->latest()->get();
        $this->setTranslations($origins, 'languages', ['products'=>'languages']);
        return $origins->first();
    }

    public function search($key, $parent_id){
        $languagesCheck = function ($query) use ($key) {
            $query->where('language_origin.title', 'like', '%' . $key . '%');
        };

        $query = $this->with('languages')->withCount('products');
        $query->whereHas('languages', $languagesCheck);
        $data = $query->latest()->get();
        $this->setTranslations($data);
        return $data;
    }
}
