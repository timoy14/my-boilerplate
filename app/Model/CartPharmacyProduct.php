<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartPharmacyProduct extends Model
{
    protected $fillable = [
        'cart_id',
        'pharmacy_product_id',
        'quantity',
        'pharmacy_product_variation_id',

    ];
    public function cart()
    {
        return $this->belongsTo('App\Model\Cart')->withTrashed();
    }
    public function pharmacy_product()
    {
        return $this->belongsTo('App\Model\PharmacyProduct')->withTrashed();
    }
    public function pharmacy_product_variation()
    {
        return $this->belongsTo('App\Model\PharmacyProductVariation')->withTrashed();
    }
}