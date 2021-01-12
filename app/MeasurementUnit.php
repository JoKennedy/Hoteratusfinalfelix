<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{

    protected $fillable = ['hotel_id', 'user_id', 'name', 'code'];
}
