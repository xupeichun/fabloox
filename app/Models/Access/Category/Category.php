<?php

namespace App\Models\Access\Category;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $hidden = [
        'status',
        'confirm',
        'created_at',
        'updated_at',
        'addedBy'
    ];



}
