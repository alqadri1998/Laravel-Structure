<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 03 Jan 2019 11:00:14 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BrandLanguage
 * 
 * @property int $language_id
 * @property int $brand_id
 * @property string $title
 * @property string $short_key
 * @property string $short_description
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 * @property string $long_description
 * 
 * @property \App\Models\Brand $brand
 * @property \App\Models\Language $language
 *
 * @package App\Models
 */
class AttributeLanguage extends Model
{
//	use \Illuminate\Database\Eloquent\SoftDeletes;
//	use \App\Models\CommonModelFunctions;
	protected $table = 'attribute_language';
//	public $incrementing = false;
//	protected $dateFormat = 'U';
//	public static $snakeAttributes = false;
//
//	protected $casts = [
//		'language_id' => 'int',
//		'brand_id' => 'int',
//		'created_at' => 'int',
//		'updated_at' => 'int'
//	];
//
//	protected $fillable = [
//		'language_id',
//		'brand_id',
//		'name',
//		'short_description',
//		'long_description'
//	];
//
//	public function attribute()
//	{
//		return $this->belongsTo(\App\Models\Attribute::class);
//	}
//
//	public function language()
//	{
//		return $this->belongsTo(\App\Models\Language::class);
//	}
}
