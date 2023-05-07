<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 20 Apr 2018 05:47:07 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleSubModule
 * 
 * @property int $role_id
 * @property int $sub_module_id
 * @property bool $mp_create
 * @property bool $mp_read
 * @property bool $mp_update
 * @property bool $mp_delete
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Role $role
 * @property \App\Models\SubModule $subModule
 *
 * @package App\Models
 */
class RoleSubModule extends Model
{
	use \App\Models\CommonModelFunctions;
	protected $table = 'role_sub_module';
	public $incrementing = false;
//	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $casts = [
		'role_id' => 'int',
		'sub_module_id' => 'int',
		'mp_create' => 'bool',
		'mp_read' => 'bool',
		'mp_update' => 'bool',
		'mp_delete' => 'bool'
	];

	protected $fillable = [
		'role_id',
		'sub_module_id',
		'mp_create',
		'mp_read',
		'mp_update',
		'mp_delete'
	];

	public function role()
	{
		return $this->belongsTo(\App\Models\Role::class);
	}

	public function subModule()
	{
		return $this->belongsTo(\App\Models\SubModule::class);
	}
}
