<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use \App\Models\CommonModelFunctions;
    use CommonFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $casts = [
        'user_id' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int'
    ];
    protected $fillable = [
        'user_id',
        'order_status',
        'total_amount',
        'billing_address',
        'shipping_address',
        'payment_status',
        'last_name',
        'payer_id',
        'charges',
        'currency',
        'transaction_details',
        'order_number',
        'description',
        'payment_id',
        'payer_email',
        'payer_status',
        'first_name',
        'payment_method',
        'paypal_response',
        'aed_price',
        'order_note',
        'image',
        'coupon_code',
        'coupon_percent',
        'vat',
        'mobile_install_fee',
        'vehicle',
        'branch',
        'find_us',
    ];



    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(\App\Models\OrderDetail::class);
    }
}
