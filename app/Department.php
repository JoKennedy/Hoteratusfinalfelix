<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function roomtaxes(){
        return $this->hasMany('App\RoomTax');
    }
}
