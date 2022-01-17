<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{use SoftDeletes;
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id')->withTrashed();
    }
    public function pharmacy()
    {
        return $this->belongsTo('App\User', 'pharmacy_id')->withTrashed();
    }
    public function user_address()
    {
        return $this->belongsTo('App\Model\UserAddress')->withTrashed();
    }
    public function discount()
    {
        return $this->belongsTo('App\Model\Discount')->withTrashed();
    }
    public function pharmacy_products()
    {
        return $this->hasMany('App\Model\PharmacyProduct', 'product_id')->withTrashed();
    }

    public function purchase_pharmacy_products()
    {
        return $this->hasMany('App\Model\PurchasePharmacyProduct', 'purchase_id');

    }
}