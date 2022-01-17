<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    public function areas()
    {
        return $this->hasMany('App\Model\Area');
    }
    public function users()
    {
        return $this->hasMany('App\User');
    }
}