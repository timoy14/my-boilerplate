<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'user_id',

    ];
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
    public function pharmacy()
    {
        return $this->belongsTo('App\User', 'pharmacy_id')->withTrashed();
    }

    public function cart_pharmacy_products()
    {
        return $this->hasMany('App\Model\CartPharmacyProduct', 'cart_id');
    }
}