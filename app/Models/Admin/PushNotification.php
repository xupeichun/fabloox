<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PushNotification
 * @package App\Models\Admin
 * @version October 23, 2017, 7:40 am UTC
 *
 * @property string title
 * @property string detail
 * @property string|\Carbon\Carbon time
 */
class PushNotification extends Model
{
    use SoftDeletes;

    public $table = 'push_notifications';


    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'notification_sent_at',
        'time'
    ];


    public $fillable = [
        'title',
        'detail',
        'time'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'detail' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'detail' => 'required',
        'time' => 'required'
    ];


}
