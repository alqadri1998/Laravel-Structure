<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    use CommonFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'code','percent','end_date','is_used'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];
}
