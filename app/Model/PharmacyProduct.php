<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmacyProduct extends Model
{
    use SoftDeletes;
    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
    public function product_category()
    {
        return $this->belongsTo('App\Model\ProductCategory')->withTrashed();
    }

    public function pharmacy_product_variations()
    {
        return $this->hasMany('App\Model\PharmacyProductVariation');
    }
    public function files()
    {
        return $this->hasMany('App\Model\File', 'pharmacy_product_id');
    }
}