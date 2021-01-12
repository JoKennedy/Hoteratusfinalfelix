<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        "name",  "address1",  "address2" ,  "country_id",  "state" ,  "city" ,  "zip_code",
        "phone",   "fax",  "website_address" ,  "gst_number",   "description"
    ];



    public function user()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function billing_address()
    {
        return $this->morphOne('App\BillingAddress', 'addressable');
    }
    public function billing_contact()
    {
        return $this->morphOne('App\BillingContact', 'contactable');
    }

    public function hotels(){
        return $this->hasMany('App\Hotel');
    }
}
