<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceProduct extends Model
{

    public function pos_product(){
        return $this->belongsTo('App\PosProduct');
    }

}
