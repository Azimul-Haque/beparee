<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function sales(){
        return $this->hasMany('App\Sale');
    }

    public function customerdues(){
        return $this->hasMany('App\Customerdue');
    }
}
