<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use \App\Models\CommonModelFunctions;
    use CommonFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'email'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];

    public function checkEmailExists(){
        return $this->where('email' , auth()->user()->email)->first();
    }

}
