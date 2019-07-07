<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function expenses(){
        return $this->hasMany('App\Expense');
    }
}
