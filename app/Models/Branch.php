<?php

namespace App\Models;

use App\Traits\Translations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;
    use CommonFunctions, Translations;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;


    protected $fillable = [
        'address',
        'timings',
        'phone',
        'whatsapp_phone',
        'longitude',
        'latitude',
        'slug',
        'image',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int'
    ];


    public function languages(){
        return $this->belongsToMany('App\Models\Language')->withPivot('title');
    }

    public function findBySlug($slug){
        $branch = $this->where('slug', $slug)->with('languages')->get();
        $this->setTranslations($branch);
        return $branch->first();
    }

    public function checkBranchDays($booking_date,$branch){
        $converted = Carbon::parse($booking_date)->format('l');
        $day = strtolower($converted);
        $branchCollection = collect($branch);
        $check = $branchCollection[$day];
        if (is_null($check)){
            return false;
        }else{
            return true;
        }
    }
    public function getImageAttribute()
    {
        if (empty($this->attributes['image']))
        {
            return url('images/default_profile.jpg');
        }
        return url($this->attributes['image']);
    }
}
