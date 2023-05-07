<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 05 Nov 2018 11:27:25 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property bool $is_default
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\Product $product
 *
 * @package App\Models
 */
class ProductImage extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Models\CommonModelFunctions;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'product_id' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int'
    ];
    protected $fillable = [
        'product_id',
        'image',
        'default_image'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function getImageAttribute()
    {

        if (!empty($this->attributes['image'])) {
            if (str_contains($this->attributes['image'], 'http')) {
                return $this->attributes['image'];
            }

            return url($this->attributes['image']);
        }
        return url(env('PRODUCT_DEFAULT_DETAIL_IMAGE'));
    }
}
