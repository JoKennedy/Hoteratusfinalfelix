<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagesMaster extends Model
{
    protected $fillable =['hotel_id', 'user_id', 'name', 'code', 'stay_length', 'description', 'acive'];

    public function hotel(){
        return $this->belongsTo('App\Hotel');
    }

    public function packages_master_rooms(){
        return $this->hasMany('App\PackagesMasterRoom');
    }
    public function inclusions(){
        return $this->belongsToMany('App\Inclusion');
    }


}
