<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use \App\Models\CommonModelFunctions;
    use CommonFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $casts = [
        'user_id' => 'int',
        'total_amount' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int'
    ];
    protected $fillable = [
        'order_id','user_id','product_id','product_price','quantity','total_price','image','item_status','extras', 'brand_image', 'with_fitting', 'name'
    ];

    public function product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


}
