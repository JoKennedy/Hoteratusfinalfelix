<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPolicy extends Model
{
    protected $fillable = ['user_id', 'hotel_id', 'name', 'before', 'before_type', 'web_policy_type_id', 'charge', 'charge_type_id'];

    public function web_policy_type(){
       return  $this->belongsTo('App\WebPolicyType');
    }

    public function room_price_policies()
    {
        return $this->morphMany('App\RoomPricePolicy', 'policyable');
    }

    public function get_description($defaultSetting)
    {
        $description = '';
        $description =
        "Requires ".($this->web_policy_type_id==2? "Credit Card Guarantee":
            ($this->web_policy_type_id == 1 ? "Credit Card with Deposit": "No Deposit "))." for booking of reservation ".
        ($this->before == null || $this->web_policy_type_id == 3 ?"for all other Day(s)": $this->before . ($this->before_type==1? " Day(s)" :" Hour(s)") )." before arrival".
        ($this->before == null || $this->web_policy_type_id == 3 ? "":", charge $this->charge" . ($this->charge_type_id == 1 ? " % of booking" : ($this->charge_type_id == 1 ? " $" : " Room Night")));

        return $description;
    }

    public function hotel()
    {

        return $this->belongsTo('App\Hotel',);
    }

}
