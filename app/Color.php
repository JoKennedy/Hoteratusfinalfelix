<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ["hotel_id", 'color'];

    public function colorable()
    {
        return $this->morphTo();
    }

    public function hotel(){
        return $this->belongsTo('App\Hotel');
    }
}
