<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 20 Apr 2018 05:47:06 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LanguageTestimonial
 * 
 * @property int $language_id
 * @property int $testimonial_id
 * @property string $full_name
 * @property string $content
 * @property string $designation
 * 
 * @property \App\Models\Language $language
 * @property \App\Models\Testimonial $testimonial
 *
 * @package App\Models
 */
class LanguageTestimonial extends Model
{
	use \App\Models\CommonModelFunctions;
	protected $table = 'language_testimonial';
	public $incrementing = false;
	public $timestamps = false;
	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $casts = [
		'language_id' => 'int',
		'testimonial_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'testimonial_id',
		'full_name',
		'content',
		'designation'
	];

	public function language()
	{
		return $this->belongsTo(\App\Models\Language::class);
	}

	public function testimonial()
	{
		return $this->belongsTo(\App\Models\Testimonial::class);
	}
}
