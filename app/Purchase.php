<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function stocks(){
        return $this->hasMany('App\Stock');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }
}
