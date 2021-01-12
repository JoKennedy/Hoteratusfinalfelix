<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlphabetCodingHotel extends Model
{
    protected $fillable = [
        'hotel_id', 'code'
    ];

    public function alphabet_coding()
    {
        return $this->belongsTo('App\AlphabetCoding');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }
}
