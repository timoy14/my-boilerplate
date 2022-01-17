<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;
    public function city()
    {
        return $this->belongsTo('App\Model\City')->withTrashed();
    }
}