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

    public function products(){
        return $this->hasMany('App\Vendor');
    }

    public function customers(){
        return $this->hasMany('App\Customer');
    }

    public function staff(){
        return $this->hasMany('App\Staff');
    }

    public function exprenses(){
        return $this->hasMany('App\Exprense');
    }

    public function expensecategories(){
        return $this->hasMany('App\Exprense');
    }

    public function purchases(){
        return $this->hasMany('App\Purchase');
    }

    public function sales(){
        return $this->hasMany('App\Sale');
    }
}
