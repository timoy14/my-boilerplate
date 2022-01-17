<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmacyProductVariation extends Model
{
    use SoftDeletes;
    public function pharmacy_product()
    {
        return $this->belongsTo('App\Model\PharmacyProduct');
    }

    public function files()
    {
        return $this->hasMany('App\Model\File', 'pharmacy_product_variation_id');
    }

    public function file()
    {
        return $this->hasOne('App\Model\File', 'pharmacy_product_variation_id');
    }
}