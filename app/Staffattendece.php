<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffattendece extends Model
{
    public function staff(){
        return $this->belongsTo('App\Staff');
    }
}
