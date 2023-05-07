<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 20 Apr 2018 05:47:07 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Testimonial
 * 
 * @property int $id
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $languages
 *
 * @package App\Models
 */
class Testimonial extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \App\Models\CommonModelFunctions;
	use CommonFunctions;
	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

	protected $casts = [
		'created_at' => 'int',
		'updated_at' => 'int'
	];

	protected $fillable = [
		'image'
	];

	public function languages()
	{
		return $this->belongsToMany(\App\Models\Language::class)
					->withPivot('full_name', 'content', 'designation');
	}
}
