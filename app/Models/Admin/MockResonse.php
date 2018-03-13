<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MockResonse
 * @package App\Models\Admin
 * @version October 3, 2017, 10:28 am UTC
 *
 * @property string name
 * @property string url
 * @property string response
 */
class MockResonse extends Model
{
    use SoftDeletes;

    public $table = 'mock_resonses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'url',
        'response'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'url' => 'string',
        'response' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'url' => 'required',
        'response' => 'required'
    ];

    
}
