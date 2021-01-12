<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancellationPolicy extends Model
{
    protected $fillable = ['user_id', 'hotel_id', 'name','before','before_type', 'charge', 'charge_type_id'];

    public function room_price_policies()
    {
        return $this->morphMany('App\RoomPricePolicy', 'policyable');
    }

    public function get_description($defaultSetting)
    {
        $description ='';
            $description = "For cancellation of reservation ".
            ($this->before_type==null? "for all other Day(s) before the check in": "after ").
            ($this->before_type == 1?date('M d, Y ', strtotime(date('Y-m-d'). "-".($this->before)." days")). date('h:i:s A', strtotime($defaultSetting['checkin_time'])) :
        date('M d, Y ') . date('h:i:s A', strtotime($defaultSetting['checkin_time'] . "-" . ($this->before) . " hours"))).
            " charge $this->charge ". ($this->charge_type_id == 1 ? '% of Booking' : ($this->charge_type_id == 2 ? '$' : 'Room Night' ));

        return $description;
    }

    public function hotel(){

        return $this->belongsTo('App\Hotel',);
    }

}
