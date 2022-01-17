<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasePharmacyProduct extends Model
{
    use SoftDeletes;
    public function purchase()
    {
        return $this->belongsTo('App\Model\Purchase')->withTrashed();
    }

    public function pharmacy()
    {
        return $this->belongsTo('App\User', 'pharmacy_id')->withTrashed();
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