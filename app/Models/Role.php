<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 20 Apr 2018 05:47:07 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $title
 * @property string $description
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $admins
 * @property \Illuminate\Database\Eloquent\Collection $subModules
 *
 * @package App\Models
 */
class Role extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \App\Models\CommonModelFunctions;
//	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'title',
		'description',
		'is_active'
	];

	public function admins()
	{
		return $this->hasMany(\App\Models\Admin::class);
	}

	public function subModules()
	{
		return $this->belongsToMany(\App\Models\SubModule::class)
					->withPivot('mp_create', 'mp_read', 'mp_update', 'mp_delete')
					->withTimestamps();
	}
    public function scopeSuperSystemAdminRoleId()
    {
        return 1;
    }
}
