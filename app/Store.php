<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function productcategories(){
        return $this->hasMany('App\Productcategory');
    }

    public function vendors(){
        return $this->hasMany('App\Vendor');
    }
}
