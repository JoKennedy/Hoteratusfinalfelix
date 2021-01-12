<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountLongStay extends Model
{
    protected $fillable = ['hotel_id', 'user_id', 'name', 'value', 'min_stay', 'discount_type'];
}
