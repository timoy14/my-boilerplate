<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;
    public function pharmacy_products()
    {
        return $this->hasMany('App\Model\PharmacyProduct', 'product_id');
    }
}