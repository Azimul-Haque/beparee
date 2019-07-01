<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function stocks(){
        return $this->hasMany('App\Stock');
    }
}
