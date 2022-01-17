<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public function getUsedDiscountCount()
    {
        $discount_count = $this->hasMany('App\Model\Purchase', 'discount_id');
        $discount_count = $discount_count->count();
        return $discount_count;
    }
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}