<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 06 Sep 2017 05:33:41 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConversionRate
 * 
 * @property int $id
 * @property int $currency_from
 * @property int $currency_to
 * @property float $rate
 * @property int $refresh_at
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 *
 * @package App\Models\Saloon
 */
class ConversionRate extends Model {

    use CommonFunctions;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public static $snakeAttributes = false;

    protected $casts = [
        'currency_from' => 'int',
        'currency_to' => 'int',
        'rate' => 'float',
        'refresh_at' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int',
        'deleted_at'=>'int'
    ];

    protected $fillable = [
        'currency_from',
        'currency_to',
        'rate',
        'refresh_at'
    ];

}
