<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\Logo;

class Hotel extends Model
{
    use Sluggable;
    use Logo;
    protected $fillable = [
    "company_id" , "name" , "slug" ,"logo","address1", "address2","country_id", "state",
    "city", "zip_code","phone","fax","website_address","email","description" , "description_service", "active",
     ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function billing_address()
    {
        return $this->morphOne('App\BillingAddress', 'addressable');
    }
    public function billing_contact()
    {
        return $this->morphOne('App\BillingContact', 'contactable');
    }

    public function amenities()
    {
        return $this->hasMany('App\Amenity');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function room_status_color(){
        return $this->hasMany('App\RoomStatusColor');
    }

    public function account_codes(){
        return $this->hasMany('App\AccountCode');
    }

    public function season_attributes(){
        return $this->hasMany('App\SeasonAttribute');
    }
    public function seasons()
    {
        return $this->hasMany('App\Season');
    }
    public function special_periods()
    {
        return $this->hasMany('App\SpecialPeriod');
    }

    public function default_setting()
    {
        return $this->hasOne('App\DefaultSetting');
    }
    public function cancellation_policies()
    {
        return $this->hasMany('App\CancellationPolicy');
    }
    public function booking_policies(){
        return $this->hasMany('App\BookingPolicy');
    }

    public function room_types(){
        return $this->hasMany('App\RoomType');
    }
    public function inclusions()
    {
        return $this->hasMany('App\Inclusion');
    }
    public function currency(){
        return $this->belongsTo('App\Currency');
    }

    public function discount_early_birds()
    {
        return $this->hasMany('App\DiscountEarlyBird');
    }
    public function discount_last_minutes()
    {
        return $this->hasMany('App\DiscountLastMinute');
    }
    public function discount_dynamic_pricings()
    {
        return $this->hasMany('App\DiscountDynamicPricing');
    }
    public function discount_long_stays()
    {
        return $this->hasMany('App\DiscountLongStay');
    }

}
