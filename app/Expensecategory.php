<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expensecategory extends Model
{
    public function expenses(){
        return $this->hasMany('App\Expense');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }
}
