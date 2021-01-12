<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontDeskPackageRoomPrice extends Model
{
    protected $fillable = [
        'front_desk_package_room_id', 'user_id', 'base_price', 'extra_person',
        'extra_bed', 'adults_minimum', 'children_minimum'
    ];


    public function front_desk_package_room(){
        return $this->belongsTo('App\FrontDeskPackageRoom');
    }
}
