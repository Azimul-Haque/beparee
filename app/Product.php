<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function productcategory(){
        return $this->belongsTo('App\Productcategory');
    }

    public function stocks(){
        return $this->hasMany('App\Stock');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function saleitems(){
        return $this->hasMany('App\Saleitem');
    }
}
