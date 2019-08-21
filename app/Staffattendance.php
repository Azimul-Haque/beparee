<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffattendance extends Model
{
    public function staff(){
        return $this->belongsTo('App\Staff');
    }
}
