<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BrandVideo
 * @package App\Models\Admin
 * @version October 26, 2017, 5:47 am UTC
 *
 * @property string name
 * @property unisingedInteger brand_id
 * @property string image
 * @property string description
 */
class BrandVideo extends Model
{
//    use SoftDeletes;

    public $table = 'brand_videos';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'brand_id',
        'image',
        'description',
        'videoLink'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'brand_id' => 'required',
        'image' => 'required'
    ];
    public static $updateRules = [
        'name' => 'required',
        'brand_id' => 'required',
    ];


}
