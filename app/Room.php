<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['hotel_id','name', 'code', 'room_type_id', 'floor_id', 'block_id', 'description'];

    public function floor()
    {
        return $this->belongsTo('App\Floor');
    }
    public function block()
    {
        return $this->belongsTo('App\Block');
    }
    public function room_type()
    {
        return $this->belongsTo('App\RoomType');
    }
    public function packages_master_rooms()
    {
        return $this->hasMany('App\PackagesMasterRoom');
    }
}
