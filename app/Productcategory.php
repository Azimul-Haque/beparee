<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productcategory extends Model
{
    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function products(){
        return $this->hasMany('App\Product');
    }
}
