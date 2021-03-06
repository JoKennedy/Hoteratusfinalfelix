<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SpecialPeriod extends Model
{
    protected $fillable = ["hotel_id", "name", "start", "end", "season_attribute_id"];

    public function season_attribute()
    {
        return $this->belongsTo('App\SeasonAttribute');
    }

    public function duration()
    {

        $start = Carbon::parse($this->start);
        $end = Carbon::parse($this->end);
        return  $end->diffInDays($start);
    }
}
