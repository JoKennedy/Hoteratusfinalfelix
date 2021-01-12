<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = ["hotel_id", "name"];

    public function rooms(){
        return $this->hasMany('App\Room');
    }
    public function other_hotel_areas()
    {
        return $this->hasMany('App\OtherHotelArea');
    }
}
