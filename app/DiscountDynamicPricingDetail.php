<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountDynamicPricingDetail extends Model
{
    protected $fillable = ['user_id', 'start_occupancy', 'end_occupancy', 'start_percentage', 'end_percentage'];
}
