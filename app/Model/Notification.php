<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    public function branch()
    {
        return $this->belongsTo('App\Model\Branch')->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}