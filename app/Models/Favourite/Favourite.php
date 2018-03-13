<?php

namespace App\Models\Favourite;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    //

//    protected $primaryKey = 'linkId';

    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at'
    ];


    protected $casts = [

        'isFavourite' => 'boolean'
    ];

    protected $fillable = [
        'user_id',
        'merchantId',
        'linkId',
        'createdOn',
        'sku',
        'productName',
        'categoryName',
        'secondaryCategoryName',
        'currency',
        'priceCurrency',
        'salePriceCurrency',
        'shortDescription',
        'longDescription',
        'linkUrl',
        'image',
        'merchantName'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
