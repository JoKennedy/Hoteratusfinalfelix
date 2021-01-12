<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherHotelArea extends Model
{
    protected $fillable = [
        'hotel_id', 'name',  'description', 'floor_id', 'block_id',
    ];
    public function block(){
        return $this->belongsTo('App\Block');
    }
    public function floor()
    {
        return $this->belongsTo('App\Floor');
    }
}
