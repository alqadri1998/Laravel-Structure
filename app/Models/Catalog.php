<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    use CommonFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'image','pdf_name'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];
    protected function getImageAttribute() {
        if (!empty($this->attributes['image'])){
            return url($this->attributes['image']);
        }
        return url('images/productDetail.png');
    }
}
