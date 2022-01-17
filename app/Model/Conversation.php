<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    public function creator()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function receiver()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}