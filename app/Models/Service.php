<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    use CommonFunctions;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'image','icon','slug', 'type'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];



    public function languages(){
        return $this->belongsToMany('App\Models\Language')->withPivot('title','description');
    }
    public function getDateStartAttribute(){
        return  Carbon::createFromTimestamp($this->start_date)->format('d-M-Y');
    }
    public function getDateEndAttribute(){
        return  Carbon::createFromTimestamp($this->end_date)->format('d-M-Y');
    }
    public function getImageAttribute()
    {
        if (empty($this->attributes['image']))
        {
            return url('images/productDetail.png');
        }
        return url( $this->attributes['image']);
    }

    public function getIconAttribute()
    {
        if (empty($this->attributes['icon']))
        {
            return url('images/productDetail.png');
        }
        return url( $this->attributes['icon']);
    }
}
