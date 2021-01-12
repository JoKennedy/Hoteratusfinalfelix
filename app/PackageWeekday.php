<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageWeekday extends Model
{
    protected $fillable = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];


    public function weekdayable()
    {
        return $this->morphTo();
    }
}
