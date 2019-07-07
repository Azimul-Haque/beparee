<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expensecategory extends Model
{
    public function exprenses(){
        return $this->hasMany('App\Exprense');
    }
}
