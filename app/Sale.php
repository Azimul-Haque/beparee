<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function customer(){
        return $this->belongsTo('App\Customer');
    }

    public function saleitems(){
        return $this->hasMany('App\Saleitem');
    }
}
