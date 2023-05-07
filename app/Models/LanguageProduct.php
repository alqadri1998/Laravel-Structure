<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 07 Jan 2019 13:08:22 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LanguageProduct
 * 
 * @property int $product_id
 * @property int $language_id
 * @property string $title
 * @property string $short_description
 * @property string $long_description
 * 
 * @property \App\Models\Language $language
 * @property \App\Models\Product $product
 *
 * @package App\Models
 */
class LanguageProduct extends Model
{
	use \App\Models\CommonModelFunctions;
	protected $table = 'language_product';
	public $incrementing = false;
	public $timestamps = false;
	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $casts = [
		'product_id' => 'int',
		'language_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'language_id',
		'title',
		'short_description',
		'long_description',
        'performance'
	];

	public function language()
	{
		return $this->belongsTo(\App\Models\Language::class);
	}

	public function product()
	{
		return $this->belongsTo(\App\Models\Product::class);
	}
}
