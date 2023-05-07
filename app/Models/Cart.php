<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use \App\Models\CommonModelFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];
    protected $fillable = [
        'product_id','user_id','quantity','product_price','total_price','extras', 'image', 'brand_id', 'origin_id', 'promotion_id','coupon'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function findByUserId(){
        return Cart::where('user_id', auth()->user()->id)->with('product')->get();
    }

    public function cartCount($id){
        return $this->where('user_id', $id)->with('product')->count();

    }
}
