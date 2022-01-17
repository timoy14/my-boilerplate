<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }
    public function pharmacy()
    {
        return $this->belongsTo('App\User', 'pharmacy_id')->withTrashed();
    }

    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id')->withTrashed();
    }

    public function purchase()
    {
        return $this->belongsTo('App\Model\Purchase', 'purchase_id')->withTrashed();
    }

}