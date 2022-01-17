<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Model\Product')->withTrashed();
    }
    public function pharmacy_product()
    {
        return $this->belongsTo('App\Model\PharmacyProduct')->withTrashed();
    }
    public function pharmacy_product_variation()
    {
        return $this->belongsTo('App\Model\PharmacyProductVariation')->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}