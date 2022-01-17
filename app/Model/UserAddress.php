<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
    public function city()
    {
        return $this->belongsTo('App\Model\City')->withTrashed();
    }
}