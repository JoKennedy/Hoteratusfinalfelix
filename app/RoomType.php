<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'hotel_id', 'name', 'code', 'description', 'base_occupancy', 'higher_occupancy',
        'exta_bed_allowed', 'exta_bed_allowed_total', 'base_price', 'higher_price', 'extra_bed_price'
    ];

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }

    public function room_taxes()
    {
        return $this->belongsToMany('App\RoomTax');
    }
    public function amenities()
    {
        return $this->belongsToMany('App\Amenity');
    }
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    public function rack_rate(){
        return RoomPrice::whereRaw("room_type_id = $this->id and priceable_type = 'Rack' and priceable_id =1")
        ->orderBy('created_at', 'desc')->first();
    }
    public function last_min_rate()
    {
        return RoomPrice::whereRaw("room_type_id = $this->id and priceable_type = 'LastMin' and priceable_id =1")
            ->orderBy('created_at', 'desc')->first();
    }
    public function web_rate()
    {
        return RoomPrice::whereRaw("room_type_id = $this->id and priceable_type = 'Web' and priceable_id =1")
            ->orderBy('created_at',  'desc')->first();
    }
    public function season_rate($id)
    {
        return RoomPrice::whereRaw("room_type_id = $this->id and priceable_type = 'App-Season' and priceable_id =$id")
            ->orderBy('created_at',  'desc')->first();
    }
    public function special_period_rate($id)
    {
        return RoomPrice::whereRaw("room_type_id = $this->id and priceable_type = 'App-SpecialPeriod' and priceable_id =$id")
            ->orderBy('created_at',  'desc')->first();
    }

    public function hotel(){
        return $this->belongsTo('App\Hotel');
    }




}


