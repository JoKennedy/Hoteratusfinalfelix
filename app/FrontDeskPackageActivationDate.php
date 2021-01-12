<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontDeskPackageActivationDate extends Model
{
    protected $fillable = [ 'front_desk_package_id', 'start', 'end' ];
}
