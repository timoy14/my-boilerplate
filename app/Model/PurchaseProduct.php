<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{

    public function purchase()
    {
        return $this->belongsTo('App\Model\Purchase')->withTrashed();
    }
}