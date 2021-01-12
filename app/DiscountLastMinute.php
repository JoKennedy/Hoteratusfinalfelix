<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountLastMinute extends Model
{
    protected $fillable = ['hotel_id', 'user_id', 'name'];

    public function discount_last_minute_details()
    {
        return $this->hasMany('App\DiscountLastMinuteDetail');
    }
}
