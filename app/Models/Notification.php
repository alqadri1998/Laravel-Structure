<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 18 Dec 2018 05:28:00 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $id
 * @property int $user1_id
 * @property int $user2_id
 * @property int $sender_id
 * @property string $title
 * @property string $description
 * @property int $extras
 * @property string $action
 * @property bool $is_seen
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Notification extends Model
{

	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \App\Models\CommonModelFunctions;
	protected $dateFormat = 'U';
	public static $snakeAttributes = false;
    protected $table = 'notifications';
	protected $casts = [
		'created_at' => 'int',
		'updated_at' => 'int'
	];

	protected $fillable = [
		'user_id',
		'admin_id',
		'extras',
		'type',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
    public function languages(){
        return $this->belongsToMany('App\Models\Language')->withPivot('title','description');
    }
//    public function delete(){
//	    dd('hello');
//        $this->languages()->delete();
//        return parent::delete();
//    }
//    public static function boot() {
//        parent::boot();
//        static::deleting(function($notification) { // before delete() method call this
//            $notification->languages()->delete();
//            // do the rest of the cleanup...
//        });
//    }
}
