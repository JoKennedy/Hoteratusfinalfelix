<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingContact extends Model
{
    protected $fillable = [
         "salutation_id" , "first_name" , "last_name" , "designation" , "phone" , "extension" , "fax" , "email" , "mobile"
         ];


    public function contactable()
    {
        return $this->morphTo();
    }
}
