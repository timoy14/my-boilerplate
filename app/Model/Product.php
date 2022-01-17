<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    public function pharmacy_products()
    {
        return $this->hasMany('App\Model\PharmacyProduct', 'product_id');
    }
    public function files()
    {
        return $this->hasMany('App\Model\File', 'product_id');
    }

}