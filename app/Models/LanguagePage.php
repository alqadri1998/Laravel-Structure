<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 20 Apr 2018 05:47:06 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LanguagePage
 * 
 * @property int $language_id
 * @property int $page_id
 * @property string $title
 * @property string $content
 * 
 * @property \App\Models\Language $language
 * @property \App\Models\Page $page
 *
 * @package App\Models
 */
class LanguagePage extends Model
{
	use \App\Models\CommonModelFunctions;
	protected $table = 'language_page';
	public $incrementing = false;
	public $timestamps = false;
	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $casts = [
		'language_id' => 'int',
		'page_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'page_id',
		'title',
		'content',
        'short_description'.
        'banner_content',
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
