<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosProduct extends Model
{


    public function product(){
        return $this->belongsTo('App\Product');
    }
    public function price_products(){
        return $this->hasMany('App\PriceProduct');
    }
    public function current_price()
    {
        return $this->price_products()->orderBy('created_at',  'desc')->first();
    }
}
