<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 30 Oct 2018 09:51:00 +0000.
 */

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property int $id
 * @property int $city_id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_address
 * @property string $email
 * @property string $password
 * @property string $user_phone
 * @property string $user_location
 * @property string $user_image
 * @property string $store_location
 * @property string $store_phone
 * @property string $store_image
 * @property string $store_slug
 * @property float $store_latitude
 * @property float $store_longitude
 * @property float $rating
 * @property int $products_counter
 * @property bool $is_store
 * @property bool $is_verified
 * @property string $verification_code
 * @property string $remember_token
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $conversations
 * @property \Illuminate\Database\Eloquent\Collection $languages
 * @property \Illuminate\Database\Eloquent\Collection $notifications
 * @property \Illuminate\Database\Eloquent\Collection $orderDetails
 * @property \Illuminate\Database\Eloquent\Collection $orders
 * @property \Illuminate\Database\Eloquent\Collection $products
 * @property \Illuminate\Database\Eloquent\Collection $reviews
 *
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    use CommonFunctions;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $casts = [
        'city_id' => 'int',
        'store_latitude' => 'float',
        'store_longitude' => 'float',
        'rating' => 'float',
        'products_counter' => 'int',
        'is_store' => 'bool',
        'is_verified' => 'bool',
        'created_at' => 'int',
        'updated_at' => 'int'
    ];
    protected $appends = ['full_name'];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'address',
        'first_name',
        'last_name',
        'email',
        'password',
        'user_phone',
        'user_image',
        'gender',
        'is_verified',
        'verification_code',
        'remember_token',
        'google_id',
        'facebook_id',
        'instagram_id',
        'session_id',
        'is_logged',
        'branch_detail',
        'telr_reference'
    ];

    public function languages()
    {
        return $this->belongsToMany(\App\Models\Language::class)
            ->withPivot('title', 'description');
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(\App\Models\OrderDetail::class, 'store_id');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    public function addresses()
    {
        return $this->hasMany(\App\Models\Address::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(\App\Models\Address::class)->where('address_type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(\App\Models\Address::class)->where('address_type', 'shipping');
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites_product');
    }

    public function carts()
    {
        return $this->hasMany(\App\Models\Cart::class);
    }


    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFull_nameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's User Image.
     *
     * @return string
     */

    public function getUserImageAttribute()
    {
        if (empty($this->attributes['user_image'])) {
            return url('images/default_profile.jpg');
        }
        return url($this->attributes['user_image']);
    }

    public function getVerificationCodeAttribute()
    {
        return strval($this->attributes['verification_code']);
    }

    public function getVerification_codeAttribute()
    {
        return strval($this->attributes['verification_code']);
    }

    public function sendPasswordResetNotification($token)
    {


        $this->notify(new PasswordResetNotification($token));
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
