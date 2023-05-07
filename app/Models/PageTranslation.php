<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 18 May 2017 13:57:51 +0400.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PageTranslation
 * 
 * @property int $id
 * @property int $language_id
 * @property int $page_id
 * @property string $title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Language $language
 * @property \App\Models\Page $page
 *
 * @package App\Models
 */
class PageTranslation extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \App\Models\CommonModelFunctions;
	public static $snakeAttributes = false;

	protected $casts = [
		'language_id' => 'int',
		'page_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'page_id',
		'title',
                'slug',
		'meta_description',
		'meta_keywords',
		'content'
	];

	public function language()
	{
		return $this->belongsTo(\App\Models\Language::class);
	}

	public function page()
	{
		return $this->belongsTo(\App\Models\Page::class);
	}
}
