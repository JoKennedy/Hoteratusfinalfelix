<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountLastMinuteDetail extends Model
{
    protected $fillable = ['user_id', 'start', 'end', 'start_percentage', 'end_percentage'];
}
