<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 03 May 2017 08:06:06 +0000.
 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Admin
 *
 * @property int $id
 * @property int $role_id
 * @property string $full_name
 * @property string $user_name
 * @property string $email
 * @property string $password
 * @property string $profile_pic
 * @property string $remember_token
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Role $role
 *
 * @package App\Models
 */
class Admin extends Authenticatable implements JWTSubject {

    use Notifiable;
    use \Illuminate\Auth\Passwords\CanResetPassword;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
//    use CommonFunctions;
    const superSystemAdminId = 1;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [

        'role_id' => 'int',
        'is_active' => 'bool'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    protected $fillable = [
        'role_id',
        'full_name',
        'user_name',
        'longitude',
        'latitude',
        'email',
        'password',
        'profile_pic',
        'remember_token',
        'is_active',
        'credit_limit',
        'total_credit_limit',
        'address'
    ];

    public function role() {
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new AdminResetPassword($token));
    }
    public function getProfile_picImageAttribute()
    {
        if (empty($this->attributes['profile_pic']))
        {
            return url( env('USER_DEFAULT_IMAGE'));
        }
        return url($this->attributes['profile_pic']);
    }

    public function getProfilePicImageAttribute()
    {
        if (empty($this->attributes['profile_pic']))
        {
            return url( env('USER_DEFAULT_IMAGE'));
        }
        return url($this->attributes['profile_pic']);
    }
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