<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequest extends Model
{
    use SoftDeletes;
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
    public function product()
    {
        return $this->belongsTo('App\Model\Product')->withTrashed();
    }

}