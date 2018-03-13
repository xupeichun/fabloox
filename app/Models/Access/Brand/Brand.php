<?php

namespace App\Models\Access\Brand;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //


    /**
     * @var array
     */
    protected $hidden = [
        'status',
        'confirm',
        'addedBy',
        'created_at',
        'updated_at',
//        'merchant_id'
    ];

    /**
     * @var array
     */
    protected $appends = [
//        'brandId',
//        'detail'
    ];


    /**
     * @return mixed
     */
//    public function getBrandIdAttribute()
//    {
//        return $this->merchant_id;
//    }

    /**
     * @return mixed
     */
//    public function getDetailAttribute()
//    {
//        return $this->description;
//    }

    public function brandVideos()
    {
        return $this->hasMany('App\Models\Admin\BrandVideo', 'brand_id', 'id');
    }
}
