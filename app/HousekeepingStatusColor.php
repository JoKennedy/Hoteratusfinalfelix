<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HousekeepingStatusColor extends Model
{
    protected $fillable = ['hotel_id', 'color'];

    public function housekeeping_status()
    {
        return $this->belongsTo('App\HousekeepingStatus');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }
}
