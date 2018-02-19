<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    //
    function users(){
        return $this->hasMany('App\User');
    }
}
