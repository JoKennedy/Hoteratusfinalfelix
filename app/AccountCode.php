<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountCode extends Model
{
      protected $fillable = [ 'name', 'code', 'hotel_id', 'property_departments_id' ];

      public function roomtaxes(){
          return $this->hasMany('App\RoomTax');
      }

      public function hotel(){
          return $this->belongsTo('App\Hotel');
      }
}
