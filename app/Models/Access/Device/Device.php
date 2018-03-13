<?php

namespace App\Models\Access\Device;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $table = 'devices';

    protected $fillable = ['device_token', 'device_type'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
