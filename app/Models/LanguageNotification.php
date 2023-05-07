<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageNotification extends Model
{
    use \App\Models\CommonModelFunctions;
    protected $table = 'language_notification';
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
        'notification_id',
        'title',
        'description'
    ];
}
