<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    protected $fillable = [
        'name', 'description'
    ];



    public function room_status_color()
    {
        return $this->hasMany('App\RoomStatusColor');
    }

    public function hotel_room_status_color($hotel_id){
        return $this->room_status_color()->where('hotel_id', $hotel_id)->first();
    }


}
