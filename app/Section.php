<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    function users(){
        return $this->hasMany('App\User');
    }
}
