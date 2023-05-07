<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 06 Sep 2017 05:33:41 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 * 
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 *
 * @package App\Models\Saloon
 */
class Currency extends Model {

    use CommonFunctions;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use CommonModelFunctions;
    public static $snakeAttributes = false;
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'deleted_at'=>'int',
        'is_active' => 'bool'
    ];
    protected $hidden = [
        'deleted_at'
    ];
    protected $fillable = [
        'title',
        'is_active'
    ];

}
