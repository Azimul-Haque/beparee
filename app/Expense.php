<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function expensecategory(){
        return $this->belongsTo('App\Expensecategory');
    }

    public function staff(){
        return $this->belongsTo('App\Staff');
    }
}
