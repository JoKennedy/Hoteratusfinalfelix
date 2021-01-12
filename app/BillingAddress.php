<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    protected $fillable = [
          "name" , "address1" , "address2" , "country_id", "state" , "city" , "zip_code" , "phone" , "fax" ,
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
