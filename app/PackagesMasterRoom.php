<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagesMasterRoom extends Model
{
    protected $fillable = [ 'packages_master_id', 'room_type_id', 'user_id', 'base_price', 'extra_person',
                            'extra_bed', 'adults_minimum', 'children_minimum'
    ];

    public function packages_master_upcharges()
    {
        return $this->hasMany('App\PackagesMasterUpcharge');
    }

    public function room_type(){
        return $this->belongsTo('App\RoomType');
    }



}
