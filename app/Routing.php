<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routing extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function item() {
        return $this->belongsTo('App\Items');
    }
    public function category() {
        return $this->belongsTo('App\Category');
    }
}
