<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
//    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];
    protected $fillable = [
        'image'
    ];


    public function getImageAttribute($image){
        return url($image);
    }
}
