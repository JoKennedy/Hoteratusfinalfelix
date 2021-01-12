<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HousekeepingStatus extends Model
{
    protected $fillable = [
        'name', 'description'
    ];


    public function housekeeping_status_color()
    {
        return $this->hasMany('App\HousekeepingStatusColor');
    }

    public function hotel_housekeeping_status_color($hotel_id)
    {
        return $this->housekeeping_status_color()->where('hotel_id', $hotel_id)->first();
    }
}
