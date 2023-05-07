<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 20 Apr 2018 05:47:07 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Module
 * 
 * @property int $id
 * @property string $title
 * @property string $href
 * @property string $icon_class
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $subModules
 *
 * @package App\Models
 */
class Module extends Model
{
	use \App\Models\CommonModelFunctions;
//	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $fillable = [
		'title',
		'href',
		'icon_class'
	];

	public function subModules()
	{
		return $this->hasMany(\App\Models\SubModule::class);
	}
}
