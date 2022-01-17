<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaffPermission extends Model
{
    protected $fillable = [
        'user_id',
        'users',
        'pharmacies',
        'orders',
        'discounts',
        'notifications',
        'payments',
        'products',
        'settings',
    ];
}
