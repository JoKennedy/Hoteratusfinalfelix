<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomPrice extends Model
{

     protected $fillable = [
        'user_id', 'priceable_type', 'priceable_id', 'room_type_id', 'base_occupancy', 'extra_person',
        'extra_bed', 'base_occupancy_high', 'extra_person_high', 'extra_bed_high', 'web', 'corp', 'agent',
        'web_policy_type_id', 'deposit_amount', 'deposit_type', 'value_type'
     ];


     public function room_type(){
         return $this->belongsTo('App\RoomType');
     }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function web_rate(){
        $webPolicy ='';
        if ($this->web == 1){
            if ($this->web_policy_type_id ==1 && $this->deposit_amount >0 && $this->deposit_type == 1 ){

                $webPolicy = "Require Deposit $this->deposit_amount".($this->value_type ==1? '% of Booking Amount':'$');
            }else if($this->web_policy_type_id ==1 && $this->deposit_type == 2){
                  $webPolicy = "As per booking Policy";
            }else if($this->web_policy_type_id ==2){
                $webPolicy = "Require Credit Card Guarantee";
            }else  if($this->web_policy_type_id ==3){
                $webPolicy = "Do not Require Deposit Or Credit Card";
            }
        }


        return $webPolicy;
    }
    public function room_price_policies(){
        return $this->hasMany('App\RoomPricePolicy');
    }
}
