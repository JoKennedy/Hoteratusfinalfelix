<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeasonAttribute extends Model
{
    protected $fillable = ["hotel_id", "name"];

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }
    public function seasons()
    {
        return $this->hasMany('App\Season');
    }
}
