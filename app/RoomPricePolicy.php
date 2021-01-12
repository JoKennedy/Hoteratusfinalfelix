<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomPricePolicy extends Model
{
    protected $fillable = ['user_id', 'room_price_id', 'policyable_id', 'policyable_type'];

    public function room_price(){
        return $this->belongsTo('App\RoomPrice');
    }

    public function policyable()
    {
        return $this->morphTo();
    }
}
