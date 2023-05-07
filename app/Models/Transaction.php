<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 17 Jan 2019 13:47:24 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * 
 * @property int $id
 * @property int $admin_id
 * @property string $polis
 * @property float $credit_limit
 * @property float $opening_balance
 * @property float $invoice_amount
 * @property float $order_amount
 * @property string $remarks
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $orders
 *
 * @package App\Models
 */
class Transaction extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use \App\Models\CommonModelFunctions;
	protected $dateFormat = 'U';
	public static $snakeAttributes = false;

	protected $casts = [
		'admin_id' => 'int',
		'credit_limit' => 'float',
		'opening_balance' => 'float',
		'invoice_amount' => 'float',
		'order_amount' => 'float',
		'created_at' => 'int',
		'updated_at' => 'int'
	];

	protected $fillable = [
		'admin_id',
		'polis',
		'credit_limit',
		'opening_balance',
		'invoice_amount',
		'order_amount',
		'remarks',
		'status'
	];

	public function orders()
	{
		return $this->hasMany(\App\Models\Order::class);
	}
    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class);
    }
    public function invoice()
    {
        return $this->belongsTo(\App\Models\Invoice::class);
    }
}
