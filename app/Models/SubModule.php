<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 20 Apr 2018 05:47:07 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubModule
 * 
 * @property int $id
 * @property int $module_id
 * @property string $title
 * @property string $path
 * @property string $route
 * @property string $icon
 * @property string $controller
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Module $module
 * @property \Illuminate\Database\Eloquent\Collection $roles
 *
 * @package App\Models
 */
class SubModule extends Model
{
	use \App\Models\CommonModelFunctions;
//	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $casts = [
		'module_id' => 'int'
	];

	protected $fillable = [
		'module_id',
		'title',
		'path',
		'route',
		'icon',
		'controller'
	];

	public function module()
	{
		return $this->belongsTo(\App\Models\Module::class);
	}

	public function roles()
	{
		return $this->belongsToMany(\App\Models\Role::class)
					->withPivot('mp_create', 'mp_read', 'mp_update', 'mp_delete')
					->withTimestamps();
	}
}
