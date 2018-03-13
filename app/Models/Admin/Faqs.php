<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Faqs
 * @package App\Models\Admin
 * @version October 30, 2017, 10:25 am UTC
 *
 * @property string question
 * @property string answer
 */
class Faqs extends Model
{
    use SoftDeletes;

    public $table = 'faqs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'question',
        'answer'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'question' => 'string',
        'answer' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question' => ['required','max:50'],
        'answer' => 'required'
    ];

    
}
