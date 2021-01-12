<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlphabetCoding extends Model
{
    protected $fillable = [
        'name', 'description'
    ];
       public function alphabet_coding_hotels()
    {
        return $this->hasMany('App\AlphabetCodingHotel');
    }

    public function alphabet_coding_hotel_code($hotel_id)
    {
        return $this->alphabet_coding_hotels()->where('hotel_id', $hotel_id)->first();
    }
}
