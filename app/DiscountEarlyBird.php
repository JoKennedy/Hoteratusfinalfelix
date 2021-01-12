<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountEarlyBird extends Model
{
    protected $fillable = ['hotel_id', 'user_id', 'name'];

    public function discount_early_bird_details(){
        return $this->hasMany('App\DiscountEarlyBirdDetail');
    }
}
