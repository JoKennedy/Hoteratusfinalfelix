<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomStatusColor extends Model
{
    protected $fillable = ['hotel_id', 'color'];
    public function room_status(){
        return $this->belongsTo('App\RoomStatus');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }
}
