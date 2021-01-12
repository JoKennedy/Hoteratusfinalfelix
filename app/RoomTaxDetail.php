<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomTaxDetail extends Model
{
    protected $fillable = ['charge_less', 'account_code_id', 'tax_value' ];

    public function room_tax(){
        return $this->belongsTo('App\RoomTax');
    }

}
