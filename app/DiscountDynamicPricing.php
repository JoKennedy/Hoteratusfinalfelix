<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountDynamicPricing extends Model
{
    protected $fillable = ['hotel_id', 'user_id', 'name'];

    public function discount_dynamic_pricing_details()
    {
        return $this->hasMany('App\DiscountDynamicPricingDetail');
    }
}
