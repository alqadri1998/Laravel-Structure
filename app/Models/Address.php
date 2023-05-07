<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    use \App\Models\CommonModelFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];
    protected $fillable = [
        'first_name','last_name','email','user_phone','address','street_address','post_code','type','user_id', 'is_default', 'city','fax', 'default_billing', 'default_shipping', 'country'
    ];

    public function getUserAddress(){
        return $this->where('user_id', auth()->id())->get();
    }
    public function getDefaultBilling(){
        return $this->where([['user_id', auth()->id()], ['default_billing', 1]])->first();
    }
    public function getDefaultShipping(){
        return $this->where([['user_id', auth()->id()], ['default_shipping', 1]])->first();
    }
    public function findById($id){
        return $this->findOrFail($id);
    }

    public function removeBillingDefault(){
        $this->where('user_id', auth()->id())->update(['default_billing' => 0]);
    }
    public function removeShippingDefault(){
        $this->where('user_id', auth()->id())->update(['default_shipping' => 0]);
    }
}
