<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Logo;


class Amenity extends Model
{
    use Logo;
     protected $fillable = [ "hotel_id", "name", "description" ];
    public function hotel(){

        return $this->belongsTo('App\Hotel');
    }
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    public function room_types()
    {
        return $this->belongsToMany('App\RoomType');
    }
}
