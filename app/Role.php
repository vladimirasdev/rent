<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    var $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
