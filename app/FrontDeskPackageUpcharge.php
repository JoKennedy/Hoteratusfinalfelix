<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontDeskPackageUpcharge extends Model
{
    protected $fillable = ['front_desk_package_room_id', 'user_id', 'persons', 'adults', 'children'];


}
