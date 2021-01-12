<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HighWeekday extends Model
{
    protected $fillable = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];


    public function default_setting(){
        return $this->belongsTo('App\DefaultSetting');
    }
}
