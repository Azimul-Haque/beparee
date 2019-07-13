<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function vendor(){
        return $this->belongsTo('App\Vendor');
    }

    public function purchase(){
        return $this->belongsTo('App\Purchase');
    }
}
