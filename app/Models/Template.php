<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 20 Apr 2018 05:47:07 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Template
 * 
 * @property int $id
 * @property string $title
 * @property string $template
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Template extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \App\Models\CommonModelFunctions;
	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $casts = [
		'created_at' => 'int',
		'updated_at' => 'int'
	];

	protected $fillable = [
		'title',
		'template'
	];
}
