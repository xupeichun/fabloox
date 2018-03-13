<?php

namespace App\Models\Access\Influencer;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $hidden =[
        'status',
        'confirm',
        'addedBy',
        'created_at',
        'updated_at'
    ];
    public function influencerVideos()
    {
        return $this->hasMany('App\Models\Access\Influencer\Influencer_video', 'influencer_id', 'id');
    }
}
