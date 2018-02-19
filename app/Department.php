<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    function users(){
        return $this->hasMany('App\User');
    }
}
