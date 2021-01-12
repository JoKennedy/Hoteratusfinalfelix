<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontDeskPackageRoom extends Model
{
    protected $fillable = [
        'front_desk_package_id', 'room_type_id', 'user_id'
    ];

    public function front_desk_package_upcharges()
    {
        return $this->hasMany('App\FrontDeskPackageUpcharge');
    }

    public function room_type()
    {
        return $this->belongsTo('App\RoomType');
    }

    public function front_desk_package(){
        return $this->belongsTo('App\FrontDeskPackage');
    }

    public function person_price($adults_minimum){

        if ($adults_minimum > $this->room_type->higher_occupancy) return '--';
        $price = $this->price();

        $adults_minimum = ($adults_minimum> $price->adults_minimum? $adults_minimum: $price->adults_minimum);
        $personExtra =  ($adults_minimum - $this->room_type->base_occupancy > 0 ? $adults_minimum - $this->room_type->base_occupancy : 0);
        $total_inclusion = $this->front_desk_package->inclusions_total();
        $extra_person =  $price->extra_person;
        $total_upcharge = 0;
        $total_upcharge_children = 0;
        foreach ($this->front_desk_package_upcharges as $key => $value) {
            if ($value['persons'] > $adults_minimum ) break;
            $total_upcharge          += $value['adults'];
            $total_upcharge_children += $value['children'];
        }

        $result = ($adults_minimum * $total_inclusion) +
        ($personExtra * $extra_person) + $price->base_price + $total_upcharge ;

        return $result;
    }
    public function children_price($adults_minimum)
    {

        $maximun = $this->room_type->higher_occupancy;
        if($adults_minimum>= $maximun) return '--';
        $total_upcharge_children = 0;
        $total_inclusion = $this->front_desk_package->inclusions_total();
        $extra_person = ($adults_minimum>0?$this->price()->extra_person:0);
        foreach ($this->front_desk_package_upcharges as $key => $value) {
            if ($value['persons'] == ($adults_minimum+1)){
                $total_upcharge_children = $value['children'];
                break;
            }
        }

        if($adults_minimum <  $this->adults_minimum ) return $total_upcharge_children;

        return $total_inclusion + $total_upcharge_children + $extra_person;
    }

    public function  front_desk_package_room_prices(){
        return $this->hasMany('App\FrontDeskPackageRoomPrice');
    }

    public function price(){
        $max = $this->front_desk_package_room_prices->max('id');
        return $this->front_desk_package_room_prices->where('id', $max)->first();
    }
}
