<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    use \App\Models\CommonModelFunctions;
    protected $table = 'favorites_product';
    public $incrementing = false;
    public $timestamps = false;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'user_id' => 'int',
        'product_id' => 'int'
    ];
    protected $fillable = [
        'user_id',
        'product_id',
    ];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
