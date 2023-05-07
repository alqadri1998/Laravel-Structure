<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 30 Oct 2018 09:52:56 +0000.
 */

namespace App\Models;
//
//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 *
 * @property int $id
 * @property string $short_code
 * @property int $is_active
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $categories
 * @property \Illuminate\Database\Eloquent\Collection $pages
 * @property \Illuminate\Database\Eloquent\Collection $products
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Language extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;

    public $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $casts = [
        'is_active' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int'
    ];

    protected $fillable = [
        'short_code',
        'is_active',
        'title'
    ];

    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class)
            ->withPivot('title', 'description');
    }

    public function pages()
    {
        return $this->belongsToMany(\App\Models\Page::class)
            ->withPivot('title', 'short_description', 'long_description');
    }

    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class)
            ->withPivot('title', 'short_description', 'long_description');
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class)
            ->withPivot('title', 'description');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class)->withPivot('name');
    }

    public function event()
    {
        return $this->belongsToMany(Event::class)->withPivot('title', 'description');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('title', 'description');
    }

    public function servicePackages()
    {
        return $this->belongsToMany(Event::class)->withPivot('title', 'description', 'short_description');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class)->withPivot('title');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class)->withPivot('title');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_language')->withPivot('name');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class)->withPivot('title', 'desctription');
    }

}
